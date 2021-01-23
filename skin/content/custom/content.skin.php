<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$content_skin_url.'/style.css">', 0);


$myid = $member['mb_id'];

?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<article id="ctt" class="ctt_<?php echo $co_id; ?>">
    <header>
        <h1><?php echo $g5['title']; ?></h1>
    </header>

    <div id="ctt_con">
        <?php echo $str; ?>
    </div>
</article>
<canvas id="canvas0" style = "border: 5px solid red;"></canvas>
<br />
<br />
<br />
<div id="canvases">
</div>
<script>
  function showEloChart(id, domId, title) {
    axios.get(`/api/get_elo_history.php?id=${id}`)
      .then(function(response) {
        console.log(response.data);
        var dataSet = {
          type: 'line',
          data: {
            labels: response.data.date,
            datasets: [{
              label: 'ELO',
              data: response.data.elo,
              borderColor: "rgba(0, 180, 14, 1)",
              backgroundColor: "rgba(0, 180, 14, 0.5)",
              fill: false,
              lineTension: 0

            }]

          },
          options: {
            responsive: true,
            title: {
              display: true,
              text: title
            },
            tooltips: {
              mode: 'index',
              intersect: false,

            },
            hover: {
              mode: 'nearest',
              intersect: true

            },
            scales: {
              xAxes: [{
                display: true,
                scaleLabel: {
                  display: true,
                  labelString: 'x축'

                }

              }],
              yAxes: [{
                display: true,
                ticks: {
                  min: Math.min.apply(null, response.data.elo) - 5,
                  max: Math.max.apply(null, response.data.elo) + 5
                },
                scaleLabel: {
                  display: false,
                  labelString: 'y축'
                }

              }]

            }

          }

        };
        new Chart(document.getElementById(domId), dataSet);
      })
      .catch(function(error) {
        console.log(error);

      });

  }


showEloChart(<?php echo "'$myid'"; ?>, 'canvas0', '본인');
axios.get(`/api/get_members.php`)
    .then(function(response) {
      console.log(response.data);
      for(var i=0; i<response.data.length; i++) {
        if (response.data[i].mb_1 != "") {
          var canvas = document.createElement("canvas");
          document.body.appendChild(canvas);
          canvas.width = window.innerWidth;
          canvas.height = 600;
          canvas.id = "elo" + i;
          canvas.style = "border: 1px solid gray;";
          var element = document.getElementById("canvases");
          element.appendChild(canvas);
          showEloChart(response.data[i].mb_id, "elo" + i, response.data[i].mb_nick);

        }
      }
    }).catch(function (error) {
        console.log(error);

    });

</script>
