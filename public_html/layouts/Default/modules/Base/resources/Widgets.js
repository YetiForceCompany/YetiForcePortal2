/* {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} */

window.Base_Dashboard_MiniList_Js = class {
	registerEvents(container) {
		container.find('.js-row').on('click', function () {
			window.location.href = $(this).data('url');
		});
	}
}

window.Base_Dashboard_ChartFilter_Js = class {
	container;
	widgetData;
	setChartContainer(container) {
		this.container = container;
	};
	getChartContainer() {
		return this.container;
	};
	getWidgetData() {
		if (typeof this.widgetData !== 'undefined') {
			return this.widgetData;
		}
		let widgetDataEl = this.getChartContainer().find('[name="widgetData"]');
		if (widgetDataEl.length) {
			return this.widgetData = JSON.parse(widgetDataEl.val());
		}
		return false;
	};
	getGlobalDefaultChartsOptions(chartSubType) {
		const options = {

			bar: {
				basic: {
					maintainAspectRatio: false,
					title: {
						display: false
					},
					legend: {
						display: 'function:legend.display()'
					},
					tooltips: {
						mode: 'point',
						callbacks: {
							label: 'function:tooltips.label',
							title: 'function:tooltips.title'
						}
					},
					scales: {
						xAxes: [{
							ticks: {
								autoSkip: false,
								beginAtZero: true,
								maxRotation: 90,
								callback: 'function:scales.formatAxesLabels'
							}
						}],
						yAxes: [{
							ticks: {
								autoSkip: false,
								beginAtZero: true,
								callback: 'function:scales.formatAxesLabels'
							}
						}]
					},
				},
				dataset: {
					datalabels: {
						font: {
							size: 11
						},
						color: 'white',
						backgroundColor: 'rgba(0,0,0,0.2)',
						borderColor: 'rgba(255,255,255,0.2)',
						borderWidth: 2,
						borderRadius: 2,
						anchor: 'center',
						align: 'center',
						formatter: 'function:datalabels.formatter',
						display: 'function:datalabels.display',
					},
				},
				plugins: [{
					beforeDraw: 'function:plugins.fixXAxisLabels',
				}, {
					beforeDraw: 'function:plugins.hideVerticalBarDatalabelsIfNeeded',
				}],
			},
			barStacked: {
				basic: {
					maintainAspectRatio: false,
					title: {
						display: false
					},
					legend: {
						display: 'function:legend.display()'
					},
					tooltips: {
						mode: 'point',
						callbacks: {
							label: 'function:tooltips.label',
							title: 'function:tooltips.title'
						}
					},
					scales: {
						xAxes: [{
							stacked: true,
							ticks: {
								autoSkip: false,
								beginAtZero: true,
								maxRotation: 90,
								callback: 'function:scales.formatAxesLabels',
							}
						}],
						yAxes: [{
							stacked: true,
							ticks: {
								autoSkip: false,
								beginAtZero: true,
								callback: 'function:scales.formatAxesLabels',
							}
						}]
					},
				},
				dataset: {
					datalabels: {
						font: {
							size: 11
						},
						color: 'white',
						backgroundColor: 'rgba(0,0,0,0.2)',
						borderColor: 'rgba(255,255,255,0.2)',
						borderWidth: 2,
						borderRadius: 2,
						anchor: 'center',
						align: 'center',
						formatter: 'function:datalabels.formatter',
						display: 'function:datalabels.display',
					},
				},
				plugins: [{
					beforeDraw: 'function:plugins.fixXAxisLabels',
				}, {
					beforeDraw: 'function:plugins.hideVerticalBarDatalabelsIfNeeded',
				}],
			},
			horizontalBar: {
				basic: {
					maintainAspectRatio: false,
					title: {
						display: false
					},
					legend: {
						display: 'function:legend.display()'
					},
					tooltips: {
						mode: 'point',
						callbacks: {
							label: 'function:tooltips.label',
							title: 'function:tooltips.title'
						}
					},
					scales: {
						xAxes: [{
							ticks: {
								autoSkip: false,
								beginAtZero: true,
								maxRotation: 90,
								callback: 'function:scales.formatAxesLabels'
							}
						}],
						yAxes: [{
							ticks: {
								autoSkip: false,
								beginAtZero: true,
								callback: 'function:scales.formatAxesLabels'
							}
						}]
					},
				},
				dataset: {
					datalabels: {
						font: {
							size: 11
						},
						color: 'white',
						backgroundColor: 'rgba(0,0,0,0.2)',
						borderColor: 'rgba(255,255,255,0.2)',
						borderWidth: 2,
						borderRadius: 2,
						anchor: 'center',
						align: 'center',
						formatter: 'function:datalabels.formatter',
						display: 'function:datalabels.display',
					},
				},
				plugins: [{
					beforeDraw: 'function:plugins.fixYAxisLabels'
				}, {
					beforeDraw: 'function:plugins.hideHorizontalBarDatalabelsIfNeeded',
				}],
			},
			horizontalBarStacked: {
				basic: {
					maintainAspectRatio: false,
					title: {
						display: false
					},
					legend: {
						display: 'function:legend.display()'
					},
					tooltips: {
						mode: 'point',
						callbacks: {
							label: 'function:tooltips.label',
							title: 'function:tooltips.title'
						}
					},
					scales: {
						xAxes: [{
							stacked: true,
							ticks: {
								autoSkip: false,
								beginAtZero: true,
								maxRotation: 90,
								callback: 'function:scales.formatAxesLabels'
							}
						}],
						yAxes: [{
							stacked: true,
							ticks: {
								autoSkip: false,
								beginAtZero: true,
								callback: 'function:scales.formatAxesLabels'
							}
						}]
					},
				},
				dataset: {
					datalabels: {
						font: {
							size: 11
						},
						color: 'white',
						backgroundColor: 'rgba(0,0,0,0.2)',
						borderColor: 'rgba(255,255,255,0.2)',
						borderWidth: 2,
						borderRadius: 2,
						anchor: 'center',
						align: 'center',
						formatter: 'function:datalabels.formatter',
						display: 'function:datalabels.display',
					},
				},
				plugins: [{
					beforeDraw: 'function:plugins.fixYAxisLabels'
				}, {
					beforeDraw: 'function:plugins.hideHorizontalBarDatalabelsIfNeeded',
				}],
			},
			line: {
				basic: {
					maintainAspectRatio: false,
					title: {
						display: false
					},
					legend: {
						display: 'function:legend.display()'
					},
					tooltips: {
						mode: 'point',
						callbacks: {
							label: 'function:tooltips.label',
							title: 'function:tooltips.title'
						}
					},
					scales: {
						xAxes: [{
							ticks: {
								autoSkip: false,
								beginAtZero: true,
								maxRotation: 90,
								callback: 'function:scales.formatAxesLabels',
								labelOffset: 0,
							}
						}],
						yAxes: [{
							ticks: {
								autoSkip: false,
								beginAtZero: true,
								callback: 'function:scales.formatAxesLabels'
							}
						}]
					},
				},
				dataset: {
					fill: false,
					datalabels: {
						font: {
							size: 11
						},
						color: 'white',
						backgroundColor: 'rgba(0,0,0,0.5)',
						borderColor: 'rgba(255,255,255,0.5)',
						borderWidth: 2,
						borderRadius: 2,
						anchor: 'bottom',
						align: 'bottom',
						formatter: 'function:datalabels.formatter',
						display: 'function:datalabels.display',
					},
				},
				plugins: [{
					beforeDraw: 'function:plugins.fixXAxisLabels'
				}],
			},
			lineStacked: {
				basic: {
					maintainAspectRatio: false,
					title: {
						display: false
					},
					legend: {
						display: 'function:legend.display()'
					},
					tooltips: {
						mode: 'point',
						callbacks: {
							label: 'function:tooltips.label',
							title: 'function:tooltips.title'
						}
					},
					scales: {
						xAxes: [{
							ticks: {
								autoSkip: false,
								beginAtZero: true,
								maxRotation: 90,
								callback: 'function:scales.formatAxesLabels',
								labelOffset: 0,
							}
						}],
						yAxes: [{
							stacked: true,
							ticks: {
								autoSkip: false,
								beginAtZero: true,
								callback: 'function:scales.formatAxesLabels'
							}
						}]
					},
				},
				dataset: {
					fill: false,
					datalabels: {
						font: {
							size: 11
						},
						color: 'white',
						backgroundColor: 'rgba(0,0,0,0.5)',
						borderColor: 'rgba(255,255,255,0.5)',
						borderWidth: 2,
						borderRadius: 2,
						anchor: 'bottom',
						align: 'bottom',
						formatter: 'function:datalabels.formatter',
						display: 'function:datalabels.display',
					},
				},
				plugins: [{
					beforeDraw: 'function:plugins.fixXAxisLabels'
				}],
			},
			linePlain: {
				basic: {
					maintainAspectRatio: false,
					title: {
						display: false
					},
					legend: {
						display: 'function:legend.display()'
					},
					tooltips: {
						mode: 'point',
						callbacks: {
							label: 'function:tooltips.label',
							title: 'function:tooltips.title'
						}
					},
					scales: {
						xAxes: [{
							ticks: {
								autoSkip: false,
								beginAtZero: true,
								maxRotation: 90,
								callback: 'function:scales.formatAxesLabels',
								labelOffset: 0,
							}
						}],
						yAxes: [{
							ticks: {
								autoSkip: false,
								beginAtZero: true,
								callback: 'function:scales.formatAxesLabels'
							}
						}]
					},
				},
				dataset: {
					lineTension: 0,
					fill: false,
					datalabels: {
						font: {
							size: 11
						},
						color: 'white',
						backgroundColor: 'rgba(0,0,0,0.5)',
						borderColor: 'rgba(255,255,255,0.5)',
						borderWidth: 2,
						borderRadius: 2,
						anchor: 'bottom',
						align: 'bottom',
						formatter: 'function:datalabels.formatter',
						display: 'function:datalabels.display',
					},
				},
				plugins: [{
					beforeDraw: 'function:plugins.fixXAxisLabels'
				}],
			},
			linePlainStacked: {
				basic: {
					maintainAspectRatio: false,
					title: {
						display: false
					},
					legend: {
						display: 'function:legend.display()'
					},
					tooltips: {
						mode: 'point',
						callbacks: {
							label: 'function:tooltips.label',
							title: 'function:tooltips.title'
						}
					},
					scales: {
						xAxes: [{
							ticks: {
								autoSkip: false,
								beginAtZero: true,
								maxRotation: 90,
								callback: 'function:scales.formatAxesLabels',
								labelOffset: 0,
							}
						}],
						yAxes: [{
							stacked: true,
							ticks: {
								autoSkip: false,
								beginAtZero: true,
								callback: 'function:scales.formatAxesLabels'
							}
						}]
					},
				},
				dataset: {
					fill: false,
					lineTension: 0,
					datalabels: {
						font: {
							size: 11
						},
						color: 'white',
						backgroundColor: 'rgba(0,0,0,0.5)',
						borderColor: 'rgba(255,255,255,0.5)',
						borderWidth: 2,
						borderRadius: 2,
						anchor: 'bottom',
						align: 'bottom',
						formatter: 'function:datalabels.formatter',
						display: 'function:datalabels.display',
					},
				},
				plugins: [{
					beforeDraw: 'function:plugins.fixXAxisLabels'
				}],
			},
			pie: {
				basic: {
					maintainAspectRatio: false,
					title: {
						display: false
					},
					legend: {
						display: true,
						labels: {
							generateLabels: 'function:legend.generateLabels',
						}
					},
					cutoutPercentage: 0,
					layout: {
						padding: {
							bottom: 12
						}
					},
					tooltips: {
						mode: 'point',
						callbacks: {
							label: 'function:tooltips.label',
							title: 'function:tooltips.title'
						}
					},
					scales: {},
				},
				dataset: {
					datalabels: {
						font: {
							size: 11
						},
						color: 'white',
						backgroundColor: 'rgba(0,0,0,0.5)',
						borderColor: 'rgba(255,255,255,0.5)',
						borderWidth: 2,
						borderRadius: 4,
						anchor: 'end',
						align: 'center',
						formatter: 'function:datalabels.formatter',
						display: 'function:datalabels.display',
					},
				},
				plugins: [],
			},
			doughnut: {
				basic: {
					maintainAspectRatio: false,
					title: {
						display: false
					},
					legend: {
						display: true,
						onClick: 'function:legend.onClick',
						labels: {
							generateLabels: 'function:legend.generateLabels',
						}
					},
					cutoutPercentage: 50,
					layout: {
						padding: {
							bottom: 12
						}
					},
					tooltips: {
						mode: 'point',
						callbacks: {
							label: 'function:tooltips.label',
							title: 'function:tooltips.title'
						}
					},
					scales: {},
				},
				dataset: {
					datalabels: {
						font: {
							size: 11
						},
						color: 'white',
						backgroundColor: 'rgba(0,0,0,0.5)',
						borderColor: 'rgba(255,255,255,0.5)',
						borderWidth: 2,
						borderRadius: 4,
						anchor: 'end',
						align: 'center',
						formatter: 'function:datalabels.formatter',
						display: 'function:datalabels.display',
					},
				},
				plugins: [],
			},
			funnel: {
				basic: {
					maintainAspectRatio: false,
					title: {
						display: false
					},
					legend: {
						display: false
					},
					sort: 'desc',
					tooltips: {
						mode: 'point',
						callbacks: {
							label: 'function:tooltips.label',
							title: 'function:tooltips.title'
						}
					},
					scales: {
						yAxes: [{
							display: true,
							beginAtZero: true,
							ticks: {
								callback: 'function:scales.formatAxesLabels'
							}
						}],
					},
				},
				dataset: {
					datalabels: {
						display: false
					}
				},
				plugins: [{
					beforeDraw: 'function:plugins.fixYAxisLabels',
				}],
			},
		};
		if (typeof options[chartSubType] !== "undefined") {
			return options[chartSubType];
		}
		// if divided and standard chart types are equal
		const notStackedChartSubType = this.removeStackedFromName(chartSubType);
		if (typeof options[notStackedChartSubType] !== "undefined") {
			return options[notStackedChartSubType];
		}
		app.errorLog(new Error(chartSubType + ' chart does not exists!'));
	};
	getDefaultDatasetOptions(chartSubType) {
		return this.getGlobalDefaultChartsOptions(chartSubType).dataset;
	};
	mergeOptionsArray(to, fromArray) {
		if (typeof to !== "undefined") {
			return to;
		}
		to = [];
		let result = fromArray.map((from, index) => {
			if (Array.isArray(from) && !to.hasOwnProperty(key)) {
				return this.mergeOptionsArray(to[index], from);
			}
			if (typeof from === 'object' && from !== null && (typeof to[index] === "undefined" || (typeof to[index] === 'object' && to[index] !== null))) {
				return this.mergeOptionsObject(to[index], from);
			}
			return to[index];
		}).filter((item) => typeof item !== "undefined");
		return result;
	}
	mergeOptionsObject(to, from) {
		if (typeof to === "undefined") {
			to = {};
		}
		for (let key in from) {
			if (from.hasOwnProperty(key)) {
				if (Array.isArray(from[key])) {
					if (!to.hasOwnProperty(key)) {
						to[key] = this.mergeOptionsArray(undefined, from[key]);
					}
				} else if (typeof from[key] === 'object' && from[key] !== null && (!to.hasOwnProperty(key) || (typeof to[key] === 'object' && to[key] !== null && !Array.isArray(to[key])))) {
					// if property is an object - merge recursively
					to[key] = this.mergeOptionsObject(to[key], from[key]);
				} else {
					if (!to.hasOwnProperty(key)) {
						to[key] = from[key];
					}
				}
			}
		}
		return to;
	};
	mergeOptions(to = {}, ...fromArray) {
		for (let i = 0, len = fromArray.length; i < len; i++) {
			if (typeof fromArray[i] !== 'object' || Array.isArray(fromArray[i])) {
				app.errorLog(new Error('Options argument should be an object! Chart subType: ' + this.getSubType() + ' [' + fromArray[i].toString() + ']'));

			} else {
				to = this.mergeOptionsObject(to, fromArray[i]);
			}
		}
		return to;
	}
	loadDatasetOptions(chartData) {
		return chartData.datasets.map((dataset, index) => {
			let result = this.mergeOptions(
				dataset,
				{},
				this.getDefaultDatasetOptions(this.getSubType())
			);
			return result;
		});
	};

	formatTooltipLabels(data) {
		data.datasets.forEach((dataset) => {
			if (typeof dataset.dataFormatted === "undefined") {
				dataset.dataFormatted = [];
				dataset.data.forEach((dataItem, index) => {
					let dataFormatted = dataItem;
					if (String(dataItem).length > 0 && !isNaN(Number(dataItem))) {
						if (typeof this.widgetData !== 'undefined' && typeof this.widgetData.valueType !== 'undefined' && this.widgetData.valueType === 'count') {
							dataFormatted = App.Fields.Double.formatToDisplay(dataItem, 0);
						} else {
							dataFormatted = App.Fields.Double.formatToDisplay(dataItem);
						}
					}
					dataset.dataFormatted.push(dataFormatted);
				});
			}
		});
	}
	formatTooltipTitles(data) {
		data.datasets.forEach((dataset) => {
			if (typeof dataset.titlesFormatted === "undefined") {
				dataset.titlesFormatted = [];
				dataset.data.forEach((dataItem, index) => {
					let defaultLabel = data.labels[index];
					if (String(defaultLabel).length > 0 && !isNaN(Number(defaultLabel))) {
						if (typeof this.widgetData !== 'undefined' && typeof this.widgetData.valueType !== 'undefined' && this.widgetData.valueType === 'count') {
							defaultLabel = App.Fields.Double.formatToDisplay(defaultLabel, 0);
						} else {
							defaultLabel = App.Fields.Double.formatToDisplay(defaultLabel);
						}
					}
					if (typeof dataset.label !== "undefined") {
						let label = dataset.label;
						if (String(label).length > 0 && !isNaN(Number(label))) {
							if (typeof this.widgetData !== 'undefined' && typeof this.widgetData.valueType !== 'undefined' && this.widgetData.valueType === 'count') {
								label = App.Fields.Double.formatToDisplay(label, 0);
							} else {
								label = App.Fields.Double.formatToDisplay(label);
							}
						}
						defaultLabel += ' (' + label + ')';
					}
					dataset.titlesFormatted.push(defaultLabel);
				});
			}
		});
	};
	getBasicOptions() {
		return {
			responsive: true,
			maintainAspectRatio: false,
		};
	}
	getDefaultBasicOptions(chartSubType) {
		return this.getGlobalDefaultChartsOptions(chartSubType).basic;
	};
	loadBasicOptions(chartData) {
		this.formatTooltipTitles(chartData);
		this.formatTooltipLabels(chartData);
		return this.mergeOptions(
			this.getBasicOptions(),
			this.getDefaultBasicOptions(this.getSubType()));
	};
	getSubType() {
		return this.getType();
	}
	isReplacementString(str) {
		if (typeof str !== 'string') {
			return false;
		}
		return str.substr(0, 9) === 'function:';
	}
	isMultiFilter() {
		if (typeof this.filterIds !== "undefined") {
			return this.filterIds.length > 1;
		}
		return false;
	}
	areColorsFromDividingField() {
		return !!Number(this.getChartContainer().find('[name="colorsFromDividingField"]').val());
	};
	globalChartFunctions = {
		/**
		 * Functions for x or y axes scales xAxes:[{here}]
		 */
		scales: {
			formatAxesLabels: function formatAxesLabels(value, index, values) {
				if (String(value).length > 0 && !isNaN(Number(value))) {
					return App.Fields.Double.formatToDisplay(value);
				}
				return value;
			},
		},
		/**
		 * Functions for datalabels
		 */
		datalabels: {
			display(context) {
				const meta = context.chart.getDatasetMeta(context.datasetIndex);
				return meta.hidden !== true;
			},
			formatter: function datalabelsFormatter(value, context) {
				if (typeof this.widgetData !== 'undefined' && typeof this.widgetData.valueType !== 'undefined' && this.widgetData.valueType === 'count') {
					return App.Fields.Double.formatToDisplay(value, 0);
				}
				if (
					typeof context.chart.data.datasets[context.datasetIndex].dataFormatted !== "undefined" &&
					typeof context.chart.data.datasets[context.datasetIndex].dataFormatted[context.dataIndex] !== "undefined"
				) {
					// data presented in different format usually exists in alternative dataFormatted array
					return context.chart.data.datasets[context.datasetIndex].dataFormatted[context.dataIndex];
				}
				if (String(value).length > 0 && isNaN(Number(value))) {
					return App.Fields.Double.formatToDisplay(value);
				}
				return value;
			}
		},
		/**
		 * Tooltips functions
		 */
		tooltips: {
			label: function tooltipLabelCallback(tooltipItem, data) {
				// get already formatted data if exists
				if (typeof data.datasets[tooltipItem.datasetIndex].dataFormatted !== "undefined" && data.datasets[tooltipItem.datasetIndex].dataFormatted[tooltipItem.index] !== "undefined") {
					return data.datasets[tooltipItem.datasetIndex].dataFormatted[tooltipItem.index];
				}
				// if there is no formatted data so try to format it
				if (String(data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index]).length > 0 && !isNaN(Number(data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index]))) {
					if (typeof this.widgetData !== 'undefined' && typeof this.widgetData.valueType !== 'undefined' && this.widgetData.valueType === 'count') {
						return App.Fields.Double.formatToDisplay(data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index], 0);
					}
					return App.Fields.Double.formatToDisplay(data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index]);
				}
				// return raw data at idex
				return data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
			},
			title: function tooltipTitleCallback(tooltipItems, data) {
				const tooltipItem = tooltipItems[0];
				// get already formatted title if exists
				if (typeof data.datasets[tooltipItem.datasetIndex].titlesFormatted !== "undefined" && data.datasets[tooltipItem.datasetIndex].titlesFormatted[tooltipItem.index] !== "undefined") {
					return data.datasets[tooltipItem.datasetIndex].titlesFormatted[tooltipItem.index];
				}
				// if there is no formatted title so try to format it
				if (String(data.labels[tooltipItem.index]).length > 0 && !isNaN(Number(data.labels[tooltipItem.index]))) {
					if (typeof this.widgetData !== 'undefined' && typeof this.widgetData.valueType !== 'undefined' && this.widgetData.valueType === 'count') {
						return App.Fields.Double.formatToDisplay(data.labels[tooltipItem.index], 0);
					}
					return App.Fields.Double.formatToDisplay(data.labels[tooltipItem.index]);
				}
				// return label at index
				return data.labels[tooltipItem.index];
			}
		},

		legend: {
			onClick(e, legendItem) {
				let type = this.chartInstance.config.type;
				if (typeof Chart.defaults[type] !== "undefined") {
					return Chart.defaults[type].legend.onClick.apply(this.chartInstance, [e, legendItem]);
				}
				return Chart.defaults.global.legend.onClick.apply(this.chartInstance, [e, legendItem]);
			},
			generateLabels(chart) {
				let type = chart.config.type;
				let labels;
				if (typeof Chart.defaults[type] !== "undefined") {
					labels = Chart.defaults[type].legend.labels.generateLabels(chart);
				} else {
					labels = Chart.defaults.global.legend.labels.generateLabels(chart);
				}

				if (this.areColorsFromDividingField() || this.isMultiFilter()) {
					chart.config.options.legend.labels.boxWidth = 12;
					labels.forEach((label, index) => {
						label.fillStyle = 'rgba(0,0,0,0)';
						label.strokeStyle = 'rgba(0,0,0,0.15)';
					});
				}
				return labels;
			},
			display() {
				if (this.isMultiFilter() || this.areColorsFromDividingField()) {
					return true;
				}
				return false;
			}
		},

		/**
		 * plugins
		 */
		plugins: {
			/**
			 * If datalabels doesn't fit - hide them individually
			 * @param  {Chart} chart chart instance
			 * @return {undefined}
			 */
			hideVerticalBarDatalabelsIfNeeded: function (chart) {
				let getDatasetsMeta = function (chart) {
					const datasets = [];
					const data = chart.data;
					if (typeof data !== "undefined" && typeof data.datasets !== "undefined" && Array.isArray(data.datasets)) {
						for (let i = 0, len = data.datasets.length; i < len; i++) {
							const meta = chart.getDatasetMeta(i);
							if (typeof meta.data !== "undefined" && Array.isArray(meta.data)) {
								datasets.push(meta);
							}
						}
					}
					return datasets;
				};
				let datasetsMeta = getDatasetsMeta(chart);
				let datasets = chart.data.datasets;
				for (let i = 0, len = datasets.length; i < len; i++) {
					const dataset = datasets[i];
					const meta = datasetsMeta[i];
					if (meta.hidden) {
						continue;
					}
					const metaData = meta.data;
					if (typeof dataset._models === "undefined") {
						dataset._models = {};
					}
					if (typeof dataset.datalabels === "undefined") {
						dataset.datalabels = {};
					}
					if (typeof dataset.datalabels.display === "undefined") {
						dataset.datalabels.display = true;
					}
					for (let iItem = 0, lenItem = metaData.length; iItem < lenItem; iItem++) {
						const dataItem = metaData[iItem];
						if (typeof dataItem.$datalabels !== "undefined" && typeof dataItem.$datalabels._model !== "undefined") {
							let model = dataItem.$datalabels._model;
							if (model !== null && typeof model !== "undefined") {
								dataset._models[iItem] = model;
							} else if (dataset._models[iItem] !== null && typeof dataset._models[iItem] !== "undefined") {
								model = dataset._models[iItem];
							} else {
								return false;
							}
							const labelWidth = model.size.width + model.padding.width + model.borderWidth * 2;
							const labelHeight = model.size.height + model.padding.height + model.borderWidth * 2;
							const barHeight = dataItem.height();
							let threshold = 10;
							if (typeof chart.config.options.verticalBarLabelsThreshold !== 'undefined') {
								threshold = chart.config.options.verticalBarLabelsThreshold;
							}
							if (dataItem._view.width + threshold < labelWidth || barHeight + threshold < labelHeight) {
								dataItem.$datalabels._model.positioner = () => {
									return false;
								}
							} else {
								dataItem.$datalabels._model = model;
							}
						}
					}
				}
			},
			/**
			 * If datalabels doesn't fit - hide them individually
			 * @param  {Chart} chart  Chart instance
			 * @return {undefined}
			 */
			hideHorizontalBarDatalabelsIfNeeded: function hideHorizontalBarDatalabelsIfNeeded(chart) {
				let getDatasetsMeta = function (chart) {
					const datasets = [];
					const data = chart.data;
					if (typeof data !== "undefined" && typeof data.datasets !== "undefined" && Array.isArray(data.datasets)) {
						for (let i = 0, len = data.datasets.length; i < len; i++) {
							const meta = chart.getDatasetMeta(i);
							if (typeof meta.data !== "undefined" && Array.isArray(meta.data)) {
								datasets.push(meta);
							}
						}
					}
					return datasets;
				};
				let datasetsMeta = getDatasetsMeta(chart);
				let datasets = chart.data.datasets;
				for (let i = 0, len = datasets.length; i < len; i++) {
					const dataset = datasets[i];
					const meta = datasetsMeta[i];
					if (meta.hidden) {
						continue;
					}
					const metaData = meta.data;
					if (typeof dataset._models === "undefined") {
						dataset._models = {};
					}
					if (typeof dataset.datalabels === "undefined") {
						dataset.datalabels = {};
					}
					if (typeof dataset.datalabels.display === "undefined") {
						dataset.datalabels.display = true;
					}
					for (let iItem = 0, lenItem = metaData.length; iItem < lenItem; iItem++) {
						const dataItem = metaData[iItem];
						if (typeof dataItem.$datalabels !== "undefined" && typeof dataItem.$datalabels._model !== "undefined") {
							let model = dataItem.$datalabels._model;
							if (model !== null && typeof model !== "undefined") {
								dataset._models[iItem] = model;
							} else if (dataset._models[iItem] !== null && typeof dataset._models[iItem] !== "undefined") {
								model = dataset._models[iItem];
							} else {
								return false;
							}
							const labelWidth = model.size.width + model.padding.width + model.borderWidth * 2;
							const labelHeight = model.size.height + model.padding.height + model.borderWidth * 2;
							const barWidth = dataItem.width;
							let threshold = 10;
							if (typeof chart.config.options.horizontalBarLabelsThreshold !== 'undefined') {
								threshold = chart.config.options.horizontalBarLabelsThreshold;
							}
							if (dataItem._view.height + threshold < labelHeight || barWidth + threshold < labelWidth) {
								dataItem.$datalabels._model.positioner = () => {
									return false;
								}
							} else {
								dataItem.$datalabels._model = model;
							}
						}
					}
				}
			},
			/**
			 * Fix to long axis labels
			 * @param  {Chart}  chart    Chart instance
			 * @return {Boolean}       [description]
			 */
			fixXAxisLabels: function fixXAxisLabels(chart) {
				let shortenXTicks = function shortenXTicks(data, options) {
					if (typeof options.scales === "undefined") {
						options.scales = {};
					}
					if (typeof options.scales.xAxes === "undefined") {
						options.scales.xAxes = [{}];
					}
					options.scales.xAxes.forEach((axis) => {
						if (typeof axis.ticks === "undefined") {
							axis.ticks = {};
						}
						axis.ticks.callback = function xAxisTickCallback(value, index, values) {
							if (value.length > 13) {
								return value.substr(0, 10) + '...';
							}
							return value;
						};
					});
					return options;
				};
				let rotateXLabels90 = function rotateXLabels90(data, options) {
					if (typeof options.scales === "undefined") {
						options.scales = {};
					}
					if (typeof options.scales.xAxes === "undefined") {
						options.scales.xAxes = [{}];
					}
					options.scales.xAxes.forEach((axis) => {
						if (typeof axis.ticks === "undefined") {
							axis.ticks = {};
						}
						axis.ticks.minRotation = 90;
					});
					return options;
				};

				chart.data.datasets.forEach((dataset, index) => {
					if (dataset._updated) {
						return false;
					}
					for (let prop in dataset._meta) {
						if (dataset._meta.hasOwnProperty(prop)) {
							for (let i = 0, len = dataset._meta[prop].data.length; i < len; i++) {
								const metaDataItem = dataset._meta[prop].data[i];
								const label = metaDataItem._xScale.ticks[i];
								const ctx = metaDataItem._xScale.ctx;
								let categoryWidth = metaDataItem._xScale.width / dataset._meta[prop].data.length;
								if (typeof metaDataItem._xScale.options.categoryPercentage !== "undefined") {
									// if it is bar chart there is category percentage option that we should use
									categoryWidth *= metaDataItem._xScale.options.categoryPercentage;
								}
								const fullWidth = ctx.measureText(label).width;
								if (categoryWidth < fullWidth) {
									const shortened = label.substr(0, 10) + "...";
									const shortenedWidth = ctx.measureText(shortened).width;
									if (categoryWidth < shortenedWidth) {
										chart.options = rotateXLabels90(chart.data, chart.options);
										chart.options = shortenXTicks(chart.data, chart.options);
									} else {
										chart.options = shortenXTicks(chart.data, chart.options);
									}
									if (!dataset._updated) {
										dataset._updated = true;
										chart.update();
										// recalculate positions for smooth animation (for all datasets)
										chart.data.datasets.forEach((dataset, index) => {
											dataset._meta[prop].data.forEach((metaDataItem, dataIndex) => {
												metaDataItem._view.x = metaDataItem._xScale.getPixelForValue(index, dataIndex);
												metaDataItem._view.base = metaDataItem._xScale.getBasePixel();
												metaDataItem._view.width = (metaDataItem._xScale.width / dataset._meta[prop].data.length) * metaDataItem._xScale.options.categoryPercentage * metaDataItem._xScale.options.barPercentage;
											});
										});
										break;
									}
								}
							}
							dataset._updated = true;
						}
					}
				});
			},
			/**
			 * Fix too long axis labels  - try to shorten and rotate
			 * @param  {Chart}  chart    Chart instance
			 * @return {Boolean}
			 */
			fixYAxisLabels: function fixYAxisLabels(chart) {
				let shortenYTicks = function shortenYTicks(data, options) {
					if (typeof options.scales === "undefined") {
						options.scales = {};
					}
					if (typeof options.scales.yAxes === "undefined") {
						options.scales.yAxes = [{}];
					}
					options.scales.yAxes.forEach((axis) => {
						if (typeof axis.ticks === "undefined") {
							axis.ticks = {};
						}
						axis.ticks.callback = function yAxisTickCallback(value, index, values) {
							if (value.length > 13) {
								return value.substr(0, 10) + '...';
							}
							return value;
						}
					});
					return options;
				};
				chart.data.datasets.forEach((dataset, index) => {
					if (dataset._updated) {
						return false;
					}
					for (let prop in dataset._meta) {
						if (dataset._meta.hasOwnProperty(prop)) {
							// we have meta
							for (let i = 0, len = dataset._meta[prop].data.length; i < len; i++) {
								const metaDataItem = dataset._meta[prop].data[i];
								const label = metaDataItem._view.label;
								if (label.length > 13) {
									chart.options = shortenYTicks(chart.data, chart.options);
									if (!dataset._updated) {
										dataset._updated = true;
										chart.update();
										// recalculate positions for smooth animation (for all datasets)
										chart.data.datasets.forEach((dataset, index) => {
											dataset._meta[prop].data.forEach((metaDataItem, dataIndex) => {
												if (typeof metaDataItem._xScale !== "undefined") {
													metaDataItem._view.x = metaDataItem._xScale.getPixelForValue(index, dataIndex);
													metaDataItem._view.base = metaDataItem._xScale.getBasePixel();
													metaDataItem._view.width = (metaDataItem._xScale.width / dataset._meta[prop].data.length) * metaDataItem._xScale.options.categoryPercentage * metaDataItem._xScale.options.barPercentage;
												}
											});
										});
										break;
									}
								}
							}
							dataset._updated = true;
						}
					}
				});
			},
		}
	}
	getFunctionFromReplacementString(replacementStr) {
		let assignResult = false;
		if (replacementStr.substr(replacementStr.length - 2) === '()') {
			replacementStr = replacementStr.substr(0, replacementStr.length - 2);
			assignResult = true;
		}
		const splitted = replacementStr.split(':');
		if (splitted.length !== 2) {
			app.errorLog(new Error("Function replacement string should look like 'function:path.to.fn' not like '" + replacementStr + "'"));
		}
		let finalFunction = splitted[1].split('.').reduce((previous, current) => {
			return previous[current];
		}, this.globalChartFunctions);
		if (typeof finalFunction !== 'function') {
			app.errorLog(new Error("Global function does not exists: " + splitted[1]));
		}
		if (!assignResult) {
			return finalFunction.bind(this);
		}
		return finalFunction.call(this);
	}
	parseOptionsArray(arr, original, afterInit = false) {
		return arr.map((item, index) => {
			if (this.isReplacementString(item)) {
				return this.getFunctionFromReplacementString(value);
			} else if (Array.isArray(item)) {
				return this.parseOptionsArray(item, original, afterInit);
			} else if (typeof item === 'object' && item !== null) {
				return this.parseOptionsObject(item, original, afterInit);
			}
			return item;
		});
	}
	parseOptionsObject(options, original, afterInit = false) {
		let result = {};
		for (let propertyName in options) {
			let value = options[propertyName];
			if (afterInit) {
				if (propertyName.substr(0, 1) === '_') {
					result[propertyName] = value;
				} else if (Array.isArray(value)) {
					result[propertyName] = this.parseOptionsArray(value, original, afterInit);
				} else if (typeof value === 'object' && value !== null) {
					result[propertyName] = this.parseOptionsObject(value, original, afterInit);
				} else {
					result[propertyName] = value;
				}
			} else {
				if (propertyName.substr(0, 1) === '_') {
					result[propertyName] = value;
				} else if (this.isReplacementString(value)) {
					result[propertyName] = this.getFunctionFromReplacementString(value, afterInit, original);
				} else if (Array.isArray(value)) {
					result[propertyName] = this.parseOptionsArray(value, original, afterInit);
				} else if (typeof value === 'object' && value !== null) {
					result[propertyName] = this.parseOptionsObject(value, original, afterInit);
				} else {
					result[propertyName] = value;
				}
			}
		}
		return result;
	}
	parseOptions(options, original, afterInit = false) {
		if (Array.isArray(options)) {
			return this.parseOptionsArray(options, original, afterInit);
		} else if (typeof options === 'object' && options !== null) {
			return this.parseOptionsObject(options, original, afterInit);
		}
		app.errorLog(new Error('Unknown options format [' + typeof options + '] - should be object.'));
	}
	loadPlugins(chartData) {
		return this.mergeOptionsArray(
			this.getPlugins(chartData),
			this.getDefaultPlugins(this.getSubType(), chartData)
		);
	}
	/**
	 * Load and display chart into the view
	 *
	 * @return {Chart} chartInstance
	 */
	loadChart() {
		if (typeof this.getChartContainer() === "undefined") {
			return false;
		}
		let data = this.getWidgetData();// load widget data for label formatters
		const type = this.getType();

		data.datasets = this.loadDatasetOptions(data);
		const options = this.parseOptions(this.loadBasicOptions(data));
		const plugins = [];
		data = this.parseOptions(data);
		const chart = this.chartInstance = new Chart(
			this.getChartContainer().find('canvas').get(0).getContext("2d"), {
				type,
				data,
				options,
				plugins
			}
		);
		// parse chart one more time after it was mounted - some options need to have chart loaded
		data.datasets = data.datasets.map((dataset, index) => {
			dataset.datasetIndex = index;
			return this.parseOptions(dataset, dataset, true);
		});
		return chart;
	};
	readData() {
		let container = this.getChartContainer();
		this.filterIds = JSON.parse(container.find('[name="filterIds"]').val());
	}
	registerEvents(container) {
		let type = container.find('[name="typeChart"]').val();
		const stacked = !!Number(container.find('[name="stacked"]').val());
		if (stacked) {
			type += 'Stacked';
		}
		var classname = 'Base_Dashboard_ChartFilter_' + type + '_Js';
		if (typeof window[classname] != 'undefined') {
			let instance = (new window[classname]());
			instance.setChartContainer(container);
			instance.readData();
			return instance.loadChart();
		} else {
			console.log('Nie znaleziono ' + classname);
		}
	};
}

window.Base_Dashboard_ChartFilter_Pie_Js = class extends Base_Dashboard_ChartFilter_Js {
	getType() {
		return 'pie';
	}
}
window.Base_Dashboard_ChartFilter_Bar_Js = class extends Base_Dashboard_ChartFilter_Js {
	getType() {
		return 'bar';
	}
}
window.Base_Dashboard_ChartFilter_BarStacked_Js = class extends Base_Dashboard_ChartFilter_Js {
	getType() {
		return 'barStacked';
	}
}

window.Base_Dashboard_ChartFilter_Horizontal_Js = class extends Base_Dashboard_ChartFilter_Bar_Js {
	getType() {
		return 'horizontalBar';
	}
}
window.Base_Dashboard_ChartFilter_HorizontalStacked_Js = class extends Base_Dashboard_ChartFilter_Horizontal_Js {
	getType() {
		return 'horizontalBar';
	}
	getSubType() {
		return 'horizontalBarStacked';
	}
}
window.Base_Dashboard_ChartFilter_Funnel_Js = class extends Base_Dashboard_ChartFilter_Js {
	getType() {
		return 'funnel';
	}
}
window.Base_Dashboard_ChartFilter_Donut_Js = class extends Base_Dashboard_ChartFilter_Pie_Js {
	getType() {
		return 'doughnut';
	}
}

window.Base_Dashboard_ChartFilter_Line_Js = class extends Base_Dashboard_ChartFilter_Js {
	getType() {
		return 'line';
	}
}

window.Base_Dashboard_ChartFilter_LineStacked_Js = class extends Base_Dashboard_ChartFilter_Line_Js {
	getType() {
		return 'line';
	}
	getSubType() {
		return 'lineStacked';
	}
}


window.Base_Dashboard_ChartFilter_LinePlain_Js = class extends Base_Dashboard_ChartFilter_Line_Js {
	getSubType() {
		return 'linePlain';
	}
}

window.Base_Dashboard_ChartFilter_LinePlainStacked_Js = class extends Base_Dashboard_ChartFilter_Line_Js {
	getSubType() {
		return 'linePlainStacked';
	}
}
