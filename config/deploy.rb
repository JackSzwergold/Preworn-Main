# config valid only for current version of Capistrano
lock '3.13.0'

set :application, 'preworn_www'
set :short_name, 'site'
set :repo_url, 'git@github.com:JackSzwergold/Preworn-Main.git'

# Default value for :scm is :git
# set :scm, :git

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
set :web_builds, "/var/www/builds"

# The directory on the server that stores content related data.
set :content_data_path, "/var/www/content"

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

      # info "Link the colorspace conversions stuff to 'colorspace'."
      execute "cd #{current_path} && ln -sf #{fetch(:web_builds)}/colorspace_conversions/#{fetch(:deployment_type)}/current #{fetch(:projects_path)}/colorspace"

      # info "If there is no symbolic link called #{fetch(:short_name)}' and '#{fetch(:short_name)}' is a directory, delete that directory."
      execute "cd /var/www/#{fetch(:live_path)} && if [ ! -h #{fetch(:short_name)} ]; then if [ -d #{fetch(:short_name)} ]; then rm -rf ./#{fetch(:short_name)}; fi; fi"

      # info "If there is a symbolic link called '#{fetch(:short_name)}', delete that directory."
      execute "cd /var/www/#{fetch(:live_path)} && if [ -h #{fetch(:short_name)} ]; then rm ./#{fetch(:short_name)}; fi"

      # info "If there is a symbolic link to '#{fetch(:short_name)}' then create a symbolic link called '#{fetch(:short_name)}'."
      execute "cd /var/www/#{fetch(:live_path)} && if [ ! -h #{fetch(:short_name)} ]; then if [ ! -d #{fetch(:short_name)} ]; then ln -sf #{current_path} ./#{fetch(:short_name)}; fi; fi"

    end
  end

  # Remove repository cruft from the deployment.
  desc "Remove cruft from the deployment."
  task :remove_cruft do
    on roles(:app) do

      # Remove files and directories that aren’t needed on a deployed install.
      # execute "cd #{current_path} && if [ -f robots.txt ]; then mv -f robots.txt robots.temp; fi && rm -rf {config,Capfile,*.html,*.txt,*.md,*.sql,.gitignore} && if [ -f 'robots.temp' ]; then mv -f robots.temp robots.txt; fi"
      execute "cd #{current_path} && if [ -f robots.txt ]; then mv -f robots.txt robots.temp; fi && rm -rf {config,Capfile,*.txt,*.md,.gitignore} && if [ -f 'robots.temp' ]; then mv -f robots.temp robots.txt; fi"

    end
  end

end

after "deploy:published", "deploy:echo_current_path"
after "deploy:published", "deploy:create_symlink"
after "deploy:finishing", "deploy:remove_cruft"
