'use strict';

const webpack = require('webpack');

module.exports = (config, webpack) => {
  // Configure date-fns Czech locale globally
  config.plugins.push(
    new webpack.NormalModuleReplacementPlugin(
      /^date-fns\/locale$/,
      function(resource) {
        // Import Czech locale by default
        resource.request = 'date-fns/locale/cs';
      }
    )
  );

  // Add alias for date-fns locale
  config.resolve.alias = {
    ...config.resolve.alias,
    'date-fns/locale': 'date-fns/locale/cs',
  };

  // Define global variables for date formatting
  config.plugins.push(
    new webpack.DefinePlugin({
      'process.env.DEFAULT_LOCALE': JSON.stringify('cs'),
      'process.env.DATE_FORMAT': JSON.stringify('d.M.yyyy'),
      'process.env.TIME_FORMAT': JSON.stringify('HH:mm'),
      'process.env.DATETIME_FORMAT': JSON.stringify('d.M.yyyy HH:mm'),
    })
  );

  return config;
};