/**
 * backbone model definitions for CARGO
 */

/**
 * Use emulated HTTP if the server doesn't support PUT/DELETE or application/json requests
 */
Backbone.emulateHTTP = false;
Backbone.emulateJSON = false

var model = {};

/**
 * long polling duration in miliseconds.  (5000 = recommended, 0 = disabled)
 * warning: setting this to a low number will increase server load
 */
model.longPollDuration = 5000;

/**
 * whether to refresh the collection immediately after a model is updated
 */
model.reloadCollectionOnModelUpdate = true;

/**
 * Customer Backbone Model
 */
model.CustomerModel = Backbone.Model.extend({
	urlRoot: 'api/customer',
	idAttribute: 'id',
	id: '',
	name: '',
	company: '',
	city: '',
	level: '',
	error: '',
	defaults: {
		'id': null,
		'name': '',
		'company': '',
		'city': '',
		'level': '',
		'error': ''
	}
});

/**
 * Customer Backbone Collection
 */
model.CustomerCollection = Backbone.Collection.extend({
	url: 'api/customers',
	model: model.CustomerModel,

	totalResults: 0,
	totalPages: 0,
	currentPage: 0,
	pageSize: 0,
	lastResponseText: null,
	collectionHasChanged: true,

	// override parse to track changes and handle pagination
	parse: function(response, xhr) {

		this.collectionHasChanged = (this.lastResponseText != xhr.responseText);
		this.lastResponseText = xhr.responseText;

		this.totalResults = response.totalResults;
		this.totalPages = response.totalPages;
		this.currentPage = response.currentPage;
		this.pageSize = response.pageSize;

		return response.rows;
	}
});

/**
 * Package Backbone Model
 */
model.PackageModel = Backbone.Model.extend({
	urlRoot: 'api/package',
	idAttribute: 'id',
	id: '',
	customerId: '',
	trackingNumber: '',
	description: '',
	service: '',
	shipDate: '',
	destination: '',
	defaults: {
		'id': null,
		'customerId': '',
		'trackingNumber': '',
		'description': '',
		'service': '',
		'shipDate': new Date(),
		'destination': ''
	}
});

/**
 * Package Backbone Collection
 */
model.PackageCollection = Backbone.Collection.extend({
	url: 'api/packages',
	model: model.PackageModel,

	totalResults: 0,
	totalPages: 0,
	currentPage: 0,
	pageSize: 0,
	lastResponseText: null,
	collectionHasChanged: true,

	// override parse to track changes and handle pagination
	parse: function(response, xhr) {

		this.collectionHasChanged = (this.lastResponseText != xhr.responseText);
		this.lastResponseText = xhr.responseText;

		this.totalResults = response.totalResults;
		this.totalPages = response.totalPages;
		this.currentPage = response.currentPage;
		this.pageSize = response.pageSize;

		return response.rows;
	}
});

/**
 * Service Backbone Model
 */
model.ServiceModel = Backbone.Model.extend({
	urlRoot: 'api/service',
	idAttribute: 'id',
	id: '',
	name: '',
	defaults: {
		'id': null,
		'name': ''
	}
});

/**
 * Service Backbone Collection
 */
model.ServiceCollection = Backbone.Collection.extend({
	url: 'api/services',
	model: model.ServiceModel,

	totalResults: 0,
	totalPages: 0,
	currentPage: 0,
	pageSize: 0,
	lastResponseText: null,
	collectionHasChanged: true,

	// override parse to track changes and handle pagination
	parse: function(response, xhr) {

		this.collectionHasChanged = (this.lastResponseText != xhr.responseText);
		this.lastResponseText = xhr.responseText;

		this.totalResults = response.totalResults;
		this.totalPages = response.totalPages;
		this.currentPage = response.currentPage;
		this.pageSize = response.pageSize;

		return response.rows;
	}
});

