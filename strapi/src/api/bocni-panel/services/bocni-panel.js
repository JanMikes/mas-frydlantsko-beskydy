'use strict';

/**
 * bocni-panel service
 */

const { createCoreService } = require('@strapi/strapi').factories;

module.exports = createCoreService('api::bocni-panel.bocni-panel');
