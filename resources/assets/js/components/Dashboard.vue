<template>
    <div>
        <new-header  :labels="labels"></new-header>
        <div v-if="series.length < 1 || chartOptions.labels.length < 1 || series[0] == 0">
            <h1>No Record Yet</h1>
        </div>
        <div class="row" v-else>
           <apexchart type="pie" width="380" :options="chartOptions" :series="series"></apexchart>
            <ul class="font-weight-bold">Total
                <li v-for="(series , index) in series" :key="index">{{ chartOptions.labels[index] }} -> ${{ series }}</li>
            </ul>
        </div>
    </div>
</template>

<script>
	var user_id = document.querySelector("meta[name='user-id']").getAttribute("content");
    export default {
        data(){
            return {
                 labels : {
                    page : 'My Expenses',
                    isChild : false,
                    parent : 'none'
                },
                series: [],
                chartOptions: {
                    chart: {
                    width: 380,
                    type: 'pie',
                    },
                    labels: [],
                    responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                        width: 200
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }]
            },
            }
        },
       created() {
           axios.get('/api/categories/'+user_id).then(({data}) => {
              this.series = data.amount;
              data.label.forEach(label => {
                  this.chartOptions.labels.push(label)
              });
               console.log(data)
           })
       },
    }
</script>
