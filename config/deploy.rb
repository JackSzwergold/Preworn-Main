# config valid only for current version of Capistrano
lock '3.6.1'

set :application, 'preworn_www'
set :short_name, 'site'
set :repo_url, 'git@github.com:JackSzwergold/Preworn-Main.git'

# Set the 'deploy_to' directory.
set :deploy_to, '/var/www'

# Default value for :scm is :git
set :scm, :git

# Default value for :format is :pretty
set :format, :pretty

# Default value for :log_level is :debug
set :log_level, :debug

# Default value for :pty is false
set :pty, false

# Default value for :linked_files is []
# set :linked_files, fetch(:linked_files, []).push('config/database.yml', 'config/secrets.yml')

# Default value for linked_dirs is []
# set :linked_dirs, fetch(:linked_dirs, []).push('log', 'tmp/pids', 'tmp/cache', 'tmp/sockets', 'vendor/bundle', 'public/system')

# Default value for default_env is {}
# set :default_env, { path: "/opt/ruby/bin:$PATH" }

# Default value for keep_releases is 5
set :keep_releases, 3

# Disable warnings about the absence of the stylesheets, javscripts & images directories.
set :normalize_asset_timestamps, false

# The directory on the server into which the actual source code will deployed.
set :web_builds, "#{deploy_to}/builds"

# The directory on the server that stores content related data.
set :content_data_path, "#{deploy_to}/content"

# The path where projects get deployed.
set :projects_path, "projects"

# The path where markdown items get deployed.
set :markdown_path, "markdown"

namespace :deploy do

  after :restart, :clear_cache do
    on roles(:web), in: :groups, limit: 3, wait: 10 do
      # Here we can do anything such as:
      # within release_path do
      #   execute :rake, 'cache:clear'
      # end
    end
  end

  # Echo the current path to a file. Needed for WordPress deployments.
  desc "Echo the current path."
  task :echo_current_path do
    on roles(:app) do

        execute "echo #{release_path} > #{release_path}/CURRENT_PATH"

    end
  end

  # Create the 'create_symlink' task to create symbolic links and other related items.
  desc "Set the symbolic links."
  task :create_symlink do
    on roles(:app) do

      # info "Link the image mosaic stuff to 'mosaic'."
      execute "cd #{current_path} && ln -sf #{fetch(:web_builds)}/mosaic/#{fetch(:deployment_type)}/current #{fetch(:projects_path)}/mosaic"

      # info "Link the mosaic javascript stuff to 'mosaic_js'."
      execute "cd #{current_path} && ln -sf #{fetch(:web_builds)}/mosaic_js_dist/#{fetch(:deployment_type)}/current #{fetch(:projects_path)}/mosaic_js"

      # info "Link the preworn ascii art stuff to 'ascii'."
      execute "cd #{current_path} && ln -sf #{fetch(:web_builds)}/ascii/#{fetch(:deployment_type)}/current #{fetch(:projects_path)}/ascii"

      # info "Link the preworn slider stuff to 'slider'."
      execute "cd #{current_path} && ln -sf #{fetch(:web_builds)}/slider/#{fetch(:deployment_type)}/current #{fetch(:projects_path)}/slider"

      # info "Link the colorspace conversions stuff to 'colorspace'."
      execute "cd #{current_path} && ln -sf #{fetch(:web_builds)}/colorspace_conversions/#{fetch(:deployment_type)}/current #{fetch(:projects_path)}/colorspace"

      # info "Link the floating cube stuff to 'floatingcube_js'."
      execute "cd #{current_path} && ln -s #{fetch(:web_builds)}/floatingcube_js_dist/#{fetch(:deployment_type)}/current #{fetch(:projects_path)}/floatingcube_js"

      # info "Link the nine dots stuff to 'ninedots_js'."
      execute "cd #{current_path} && ln -s #{fetch(:web_builds)}/ninedots_js_dist/#{fetch(:deployment_type)}/current #{fetch(:projects_path)}/ninedots_js"

      # info "Link the lexicon stuff to 'lexicon'."
      execute "cd #{current_path} && ln -s #{fetch(:web_builds)}/lexicon/#{fetch(:deployment_type)}/current #{fetch(:projects_path)}/lexicon"

      # info "Link the lexicon stuff to 'lexicon_js'."
      execute "cd #{current_path} && ln -s #{fetch(:web_builds)}/lexicon_js_dist/#{fetch(:deployment_type)}/current #{fetch(:projects_path)}/lexicon_js"

      # info "Link the instagram stuff to 'instagram'."
      execute "cd #{current_path} && ln -s #{fetch(:web_builds)}/instagram/#{fetch(:deployment_type)}/current #{fetch(:projects_path)}/instagram"

      # info "Link the cheat sheet stuff to 'tutorials_and_cheat_sheets'."
      execute "cd #{current_path} && ln -s #{fetch(:web_builds)}/tutorials_and_cheat_sheets/#{fetch(:deployment_type)}/current #{fetch(:markdown_path)}/tutorials_and_cheat_sheets"

      # info "If there is no directory & no symbolic link to '#{fetch(:short_name)}' then create a directory named '#{fetch(:short_name)}'."
      # execute "cd #{fetch(:live_root)} && if [ ! -d #{fetch(:short_name)} ]; then if [ ! -h #{fetch(:short_name)} ]; then mkdir -p ./#{fetch(:short_name)}; fi; fi"

      # info "If there is no symbolic link called #{fetch(:short_name)}' and '#{fetch(:short_name)}' is a directory, delete that directory."
      execute "cd #{fetch(:live_root)} && if [ ! -h #{fetch(:short_name)} ]; then if [ -d #{fetch(:short_name)} ]; then rm -rf ./#{fetch(:short_name)}; fi; fi"

      # info "If there is a symbolic link called '#{fetch(:short_name)}', delete that directory."
      execute "cd #{fetch(:live_root)} && if [ -h #{fetch(:short_name)} ]; then rm ./#{fetch(:short_name)}; fi"

      # info "If there is a symbolic link to '#{fetch(:short_name)}' then create a symbolic link called '#{fetch(:short_name)}'."
      execute "cd #{fetch(:live_root)} && if [ ! -h #{fetch(:short_name)} ]; then if [ ! -d #{fetch(:short_name)} ]; then ln -sf #{current_path} ./#{fetch(:short_name)}; fi; fi"

    end
  end

  # Remove repository cruft from the deployment.
  desc "Remove cruft from the deployment."
  task :remove_cruft do
    on roles(:app) do

        # Remove any README file that ends in '.md' or '.txt'.
        execute "cd #{current_path} && rm -f README*.{md,txt}"

        # Remove the Capisrano related files and directories.
        execute "cd #{current_path} && rm -rf config && rm -f Capfile"

        # Remove the 'htaccess.txt' file.
        execute "cd #{current_path} && rm -f htaccess.txt"

        # Remove the 'LICENSE.txt' file.
        execute "cd #{current_path} && rm -f LICENSE.txt"

    end
  end

end

after "deploy:published", "deploy:echo_current_path"
after "deploy:published", "deploy:create_symlink"
after "deploy:finishing", "deploy:remove_cruft"
