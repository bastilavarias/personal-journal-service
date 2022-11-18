option_settings:
  aws:elasticbeanstalk:container:php:phpini:
    document_root: /public
    memory_limit: 256M
  aws:elasticbeanstalk:application:environment:
    COMPOSER_HOME: /root
    APP_DEBUG: FALSE
    APP_ENV: local
    APP_KEY: 
    APP_NAME: 
    APP_URL: 
    DB_CONNECTION: 
    DB_DATABASE: 
    DB_HOST: 
    DB_USERNAME: 
    DB_PASSWORD: 
    DB_PORT: 3306
    AWS_ACCESS_KEY_ID: 
    AWS_SECRET_ACCESS_KEY: 
    AWS_DEFAULT_REGION: ap-southeast-1
    AWS_BUCKET: 
    AWS_REGION: 
    FILESYSTEM_DRIVER: s3
    FILESYSTEM_CLOUD: s3
container_commands:
  01folder-permissions:
    command: |
      chmod -R 775 /var/app/ondeck/storage
      chmod -R 775 /var/app/ondeck/bootstrap