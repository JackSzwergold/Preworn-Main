# branch: Set the github branch that will be used for this deployment.
# server: The name of the destination server you will be deploying to.
# web_builds: The directory on the server into which the actual source code will deployed.
# live_root: The live directory which the current version will be linked to.

set :branch, "develop"

server "www.preworn.com", :app, :web, :db, :primary => true
set :web_builds, "#{deployment_root}/builds"
set :content_data_path, "#{deployment_root}/content/#{application}/staging"
set :live_root, "#{deployment_root}/staging.preworn.com"

set :deploy_to, "#{web_builds}/#{application}/staging"

# Remote caching will keep a local git repository on the server you're deploying to and
# simply run a fetch from that rather than an entire clone. This is probably the best
# option as it will only fetch the changes since the last deploy.
set :deploy_via, :remote_cache

# Disable warnings about the absence of the styleseheets, javscripts & images directories.
set :normalize_asset_timestamps, false

# before "deploy:create_symlink", :make_cache_link

after "deploy:create_symlink" do
  # Link the image mosaic stuff to 'mosaic'
  run "cd #{current_release} && ln -s #{web_builds}/image_mosaic/staging/current mosaic"
  # Link the preworn slider stuff to 'slider'
  run "cd #{current_release} && ln -s #{web_builds}/preworn_slider/staging/current slider"
  # Link the preworn ascii art stuff to 'ascii'
  run "cd #{current_release} && ln -s #{web_builds}/ascii_art/staging/current ascii"
  # If there is no directory & no symbolic link to 'site' then create a directory named 'site'.
  # run "cd #{live_root} && if [ ! -d site ]; then if [ ! -h site ]; then mkdir ./site; fi; fi"
  # If there is no symbolic link called site' and 'site' is a directory, delete that directory.
  run "cd #{live_root} && if [ ! -h site ]; then if [ -d site ]; then rm -rf ./site; fi; fi"
  # If there is a symbolic link called 'site', delete that directory.
  run "cd #{live_root} && if [ -h site ]; then rm ./site; fi"
  # If there is a symbolic link to 'site' then create a symbolic link called 'site'.
  run "cd #{live_root} && if [ ! -h site ]; then if [ ! -d site ]; then ln -sf #{current_path} ./site; fi; fi"
end

after "deploy:update", "deploy:cleanup"