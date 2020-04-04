const path = require('path');
const webpack = require('webpack');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const CopyPlugin = require('copy-webpack-plugin');

var entries = {
  // main: ['./resources/entries/admin.js'],
  // site entrires
  'site': ['./resources/entries/site.js', ], 
  'site.vendor.css': ['materialize-css/dist/css/materialize.min.css', ], 
  'site.vendor.js': ['materialize-css/dist/js/materialize.min.js', ], 
  // admin entires
  'admin': ['./resources/entries/admin.js', ], 
  'admin.vendor.js': ['backbone', 'jquery', 'underscore', 'ol', ],
  'admin.vendor.css': ['bootstrap/dist/css/bootstrap.min.css', ],
  // login entries
  'login': ['./resources/entries/login.js', ], 
  // error entries
  'error': ['./resources/entries/error.js', ], 
};

var plugins = [
  new webpack.ProvidePlugin({
    // import globally this libs
    '$': 'jquery',
    'jQuery':'jquery',
    'window.jQuery':'jquery',
    'Backbone': 'backbone',
    '_': 'underscore',
  }),
  new MiniCssExtractPlugin({
    // Options similar to the same options in webpackOptions.output
    // both options are optional
    filename: '[name].css',
    chunkFilename: '[name].css',
  }),
  new CopyPlugin([
    // move ejs files to public
    { 
      from: 'resources/templates', 
      to: '../templates' 
    },
  ]),
];

var outputDevelopment = {
  path: path.resolve(__dirname, 'public/dist'),
  filename: '[name].js',
  //chunkFilename: '[chunkhash].js',
};

var outputProduction = {
  path: path.resolve(__dirname, 'public/dist'),
  filename: '[name].min.js',
  //chunkFilename: '[chunkhash].min.js',
};

var rules = [
  {
    test: /\.css$/,
    use: [
      {
        loader: MiniCssExtractPlugin.loader,
        options: {
          // you can specify a publicPath here
          // by default it use publicPath in webpackOptions.output
          publicPath: '../'
        }
      },
      'css-loader'
    ]
  },
];

var optimization = {
  splitChunks: {
    cacheGroups: {      
      /* 
      vendor: {
        test: /node_modules/,
        name: 'vendors',
        chunks: 'all', 
        enforce: true,
      },
      */
      adminVendor: {
        test: 'admin.vendor.js',
        name: 'admin.vendor',
        chunks: 'all', 
        enforce: true,
      },
      adminVendorCSS: {
        test: 'admin.vendor.css',
        name: 'admin.vendor',
        chunks: 'all', 
        enforce: true,
      },
      siteVendor: {
        test: 'site.vendor.js',
        name: 'site.vendor',
        chunks: 'all', 
        enforce: true,
      },
      siteVendorCSS: {
        test: 'site.vendor.css',
        name: 'site.vendor',
        chunks: 'all', 
        enforce: true,
      },
    }
  }
};

var devServer = {
  host: '0.0.0.0',
  port: 8090,
  contentBase: [
    path.join(__dirname, 'public'),
  ],
  publicPath: path.join(__dirname, 'resources'),
  writeToDisk: true,
  compress: true,
  watchContentBase: true,
  hot: true,
  inline:true,
  allowedHosts: [
    'host.com',
    '*',
  ],
  headers: {
    'Server': 'Ubuntu',
  },
};

var config = {
  entry: entries,
  plugins: plugins,
  optimization: optimization,
  module: {
    rules: rules,
  },
  devServer: devServer,
};

module.exports = (env, argv) => {
  if (argv.mode === 'development') {
    config.output = outputDevelopment;
    config.watch = true;
  }
  if (argv.mode === 'production') {
    config.output = outputProduction;
    config.watch = false;
    config.devServer = {};
  }
  return config;
};