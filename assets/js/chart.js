const ctx = document.getElementById('grafik');

new Chart(ctx, {

type: 'line',

data: {

labels: ['Sen','Sel','Rab','Kam','Jum'],

datasets: [{

label: 'Penjualan',

data: [12,19,8,15,20],

borderWidth: 2

}]

}

});