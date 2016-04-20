# Set the github branch that will be used for this deployment.
set :branch, "master"

# The details of the destination server you will be deploying to.
server 'sandbox.local', user: ENV["CAP_USER"] || 'vagrant', roles: %w{app db web}, my_property: :my_value

# Set the name for the deployment type.
set :deployment_type, "production"

# The live, web root directory which the current version will be linked to.
set :live_root, "#{deploy_to}/staging.preworn.com"

# The directory on the server into which the actual source code will deployed.
set :web_builds, "#{deploy_to}/builds"

# The path where projects get deployed.
set :projects_path, "projects"

# The directory on the server that stores content related data.
set :content_data_path, "#{deploy_to}/content"

# Set the 'deploy_to' directory for this task.
set :deploy_to, "/var/www/builds/#{fetch(:application)}/#{fetch(:deployment_type)}"

# Disable warnings about the absence of the styleseheets, javscripts & images directories.
set :normalize_asset_timestamps, false

# Create the 'create_symlink' task to create symbolic links and other related items.
namespace :deploy do

  desc "Set the symbolic links."
  task :create_symlink do
    on roles(:app) do

      # info "Link the cheat sheet stuff to 'tutorials_and_cheat_sheets'."
      execute "cd #{current_path} && ln -s #{fetch(:web_builds)}/tutorials_and_cheat_sheets/#{fetch(:deployment_type)}/current markdown/tutorials_and_cheat_sheets"

      # info "Link the image mosaic stuff to 'mosaic'."
      execute "cd #{current_path} && ln -sf #{fetch(:web_builds)}/mosaic/#{fetch(:deployment_type)}/current #{fetch(:projects_path)}/mosaic"

      # info "Link the mosaic javascript stuff to 'mosaic_js'."
      execute "cd #{current_path} && ln -sf #{fetch(:web_builds)}/mosaic_js_dist/#{fetch(:deployment_type)}/current #{fetch(:projects_path)}/mosaic_js"

      # info "Link the preworn ascii art stuff to 'ascii'."
      execute "cd #{current_path} && ln -sf #{fetch(:web_builds)}/ascii/#{fetch(:deployment_type)}/current #{fetch(:projects_path)}/ascii"

      # info "Link the preworn slider stuff to 'slider'."
      execute "cd #{current_path} && ln -sf #{fetch(:web_builds)}/slider/#{fetch(:deployment_type)}/current #{fetch(:projects_path)}/slider"

      # info "Link the colorspace conversions stuff to 'colorspace'."
      execute "cd #{current_path} && ln -sf #{fetch(:web_builds)}/colorspace_conversions/#{fetch(:deployment_type)}/current projects/colorspace"

      # info "If there is no directory & no symbolic link to '#{fetch(:short_name)}' then create a directory named '#{fetch(:short_name)}'."
      # execute "cd #{fetch(:live_root)} && if [ ! -d #{fetch(:short_name)} ]; then if [ ! -h #{fetch(:short_name)} ]; then mkdir ./#{fetch(:short_name)}; fi; fi"

      # info "If there is no symbolic link called #{fetch(:short_name)}' and '#{fetch(:short_name)}' is a directory, delete that directory."
      execute "cd #{fetch(:live_root)} && if [ ! -h #{fetch(:short_name)} ]; then if [ -d #{fetch(:short_name)} ]; then rm -rf ./#{fetch(:short_name)}; fi; fi"

      # info "If there is a symbolic link called '#{fetch(:short_name)}', delete that directory."
      execute "cd #{fetch(:live_root)} && if [ -h #{fetch(:short_name)} ]; then rm ./#{fetch(:short_name)}; fi"

      # info "If there is a symbolic link to '#{fetch(:short_name)}' then create a symbolic link called '#{fetch(:short_name)}'."
      execute "cd #{fetch(:live_root)} && if [ ! -h #{fetch(:short_name)} ]; then if [ ! -d #{fetch(:short_name)} ]; then ln -sf #{current_path} ./#{fetch(:short_name)}; fi; fi"

    end
  end

end

after "deploy:published", "deploy:create_symlink"