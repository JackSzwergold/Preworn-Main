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

after "deploy:published", "deploy:create_symlink"