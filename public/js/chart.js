function initChart(element, type, labels, label_name, datas, colors, offset = 4, position = 'right', name) {
    return element ? new Chart(element, {

        type: type,
        data: {
            labels: labels,
            datasets: [{
                label: label_name,
                data: datas,
                backgroundColor: colors,
                hoverOffset: offset
            }]
        },
        plugins: [HTMLLegendPlugin],
        options: {
            plugins: {
                htmlLegend: {
                    containerID: name + '-legend-container'
                },
                legend: {
                    display: false,
                },

                tooltip: {
                    callbacks: {
                        /* title: function(tooltipItems, data) {
                             return '';
                         },*/
                        label: function (tooltipItem) {
                            return tooltipItem.formattedValue + " %";
                        },
                    },
                },
            }
        }
    }) : null;
}

function getBoxWidth(labelOpts, fontSize) {
    return labelOpts.usePointStyle ?
        fontSize * Math.SQRT2 :
        labelOpts.boxWidth;
}

function createNewLegendAndAttach(chartInstance, legendOpts) {
    var legend = new Chart.NewLegend({
        ctx: chartInstance.chart.ctx,
        options: legendOpts,
        chart: chartInstance
    });

    if (chartInstance.legend) {
        Chart.layoutService.removeBox(chartInstance, chartInstance.legend);
        delete chartInstance.newLegend;
    }

    chartInstance.newLegend = legend;
    Chart.layoutService.addBox(chartInstance, legend);
}

const getOrCreateLegendList = (chart, id) => {
    const legendContainer = document.getElementById(id);
    let listContainer = legendContainer.querySelector('ul');

    const { type } = chart.config;

    if (!listContainer) {
        listContainer = document.createElement('ul');
        listContainer.style.display = 'flex';
        listContainer.style.flexDirection = (type === 'pie' || type === 'doughnut') ? 'column' : 'row';
        listContainer.style.margin = 0;
        listContainer.style.padding = 0;

        legendContainer.appendChild(listContainer);
    }

    return listContainer;
};

const HTMLLegendPlugin = {
    id: 'htmlLegend',
    afterUpdate(chart, args, options) {
        let shouldDisplay = false
        if(!shouldDisplay) {
            return;
        }

        const ul = getOrCreateLegendList(chart, options.containerID);
        ul.innerHTML = '';

        // Reuse the built-in legendItems generator
        const { type } = chart.config;
        const items = chart.options.plugins.legend.labels.generateLabels(chart);

        items.forEach(item => {
            const li = document.createElement('li');
            li.style.alignItems = 'center';
            li.style.cursor = 'pointer';
            li.style.display = 'flex';
            li.style.flexDirection = 'row';
            li.style.marginLeft = '10px';

            li.onclick = () => {
                if (type === 'pie' || type === 'doughnut') {
                    // Pie and doughnut charts only have a single dataset and visibility is per item
                    chart.toggleDataVisibility(item.index);
                } else {
                    chart.setDatasetVisibility(item.datasetIndex, !chart.isDatasetVisible(item.datasetIndex));
                    item.hidden = !item.hidden;
                }


                if (options.onclick) options.onclick(item, items, chart);

                chart.update();
            };

            // Color box
            const boxSpan = document.createElement('span');
            boxSpan.style.background = item.fillStyle;
            boxSpan.style.borderColor = item.strokeStyle;
            boxSpan.style.borderStyle = 'solid';
            boxSpan.style.borderWidth = item.lineWidth + 'px';
            boxSpan.style.display = 'inline-block';
            boxSpan.style.height = '20px';
            boxSpan.style.marginRight = '10px';
            boxSpan.style.width = '20px';

            // Text
            const textContainer = document.createElement('p');
            textContainer.style.color = item.hidden ? (options.hiddenFontColor ?? '#cccccc') : (options.fontColor ?? item.fontColor);
            textContainer.style.margin = 0;
            textContainer.style.padding = 0;

            const text = document.createTextNode(item.text);
            textContainer.appendChild(text);

            li.appendChild(boxSpan);
            li.appendChild(textContainer);
            ul.appendChild(li);
        });
    }
};

window.addEventListener('load', function () {

});
