# branch: Set the github branch that will be used for this deployment.
# server: The name of the destination server you will be deploying to.
# web_builds: The directory on the server into which the actual source code will deployed.
# live_root: The live directory which the current version will be linked to.

set :branch, "master"

server 'www.preworn.com', user: 'sysop', roles: %w{app db web}, my_property: :my_value

set :web_builds, "#{deploy_to}/builds"
set :content_data_path, "#{deploy_to}/content"
set :live_root, "#{deploy_to}/www.preworn.com"

set :deploy_to, "/var/www/builds/#{fetch(:application)}/production"

# Disable warnings about the absence of the styleseheets, javscripts & images directories.
set :normalize_asset_timestamps, false

# Set symbollic links and other related items.
namespace :deploy do

  desc "Set the symbolic links."
  task :create_symlink do
    on roles(:app) do

        info "Link the image mosaic stuff to 'mosaic'."
        execute "cd #{current_path} && ln -s #{fetch(:web_builds)}/image_mosaic/production/current mosaic"

        info "Link the preworn ascii art stuff to 'ascii'."
        execute "cd #{current_path} && ln -s #{fetch(:web_builds)}/image_ascii/production/current ascii"

        info "Link the preworn slider stuff to 'slider'."
        execute "cd #{current_path} && ln -s #{fetch(:web_builds)}/preworn_slider/production/current slider"

        info "Link the colorspace conversions stuff to 'colorspace'."
        execute "cd #{current_path} && ln -s #{fetch(:web_builds)}/colorspace_conversions/production/current colorspace"

        # info "If there is no directory & no symbolic link to 'site' then create a directory named 'site'."
        # execute "cd #{fetch(:live_root)} && if [ ! -d site ]; then if [ ! -h site ]; then mkdir ./site; fi; fi"

        # info "If there is no symbolic link called site' and 'site' is a directory, delete that directory."
        execute "cd #{fetch(:live_root)} && if [ ! -h site ]; then if [ -d site ]; then rm -rf ./site; fi; fi"

        # info "If there is a symbolic link called 'site', delete that directory."
        execute "cd #{fetch(:live_root)} && if [ -h site ]; then rm ./site; fi"

        # info "If there is a symbolic link to 'site' then create a symbolic link called 'site'."
        execute "cd #{fetch(:live_root)} && if [ ! -h site ]; then if [ ! -d site ]; then ln -sf #{current_path} ./site; fi; fi"

    end
  end

end

# after :deploy, "deploy:create_symlink"
after "deploy:published", "deploy:create_symlink"