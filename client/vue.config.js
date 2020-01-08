const path = require('path');

module.exports = {
	outputDir: path.resolve(__dirname, '/public'),
	devServer: {
		proxy: {
			'/': {
				target: 'http://localhost/cioauth'
			}
		}
	}
};
