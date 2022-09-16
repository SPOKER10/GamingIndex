<?php
  //Players Graph
  require_once 'mdb.php';
  $link = new MySQLi(DB_HOST, DB_USER, DB_PASS, DB_NAME);
  $query = mysqli_query($link, "SELECT record_players, record_date FROM inf_record LIMIT 29");
  while($row=mysqli_fetch_array($query))
  {
    $data[] = $row['record_date'];
    $players[] = $row['record_players'];
  }

  //Last Register
  $query = mysqli_query($link, "SELECT ID, user, Score, RPoints, HoursPlayed, Job, SkinID, RegDate FROM players ORDER BY ID DESC LIMIT 1");
  $row=mysqli_fetch_array($query);
  switch($row['Job'])
  {
      case 0: $lJob = 'Job: Unemployed'; break;
      case 1: $lJob = 'Job: Detective'; break;
      case 2: $lJob = 'Job: Street Sweeper'; break;
      case 3: $lJob = 'Job: Farmer'; break;
      case 4: $lJob = 'Job: Trucker'; break;
      case 5: $lJob = 'Job: Pizza Boy'; break;
      case 6: $lJob = 'Job: Garbage Man'; break;
      case 7: $lJob = 'Job: Arms Dealer'; break;
      case 8: $lJob = 'Job: Drugs Dealer'; break;
      case 9: $lJob = 'Job: StuntMan'; break;
      case 10: $lJob = 'Job: Mechanic'; break;
      case 10: $lJob = 'Job: Miner'; break;
      case 12: $lJob = 'Job: Fisher'; break;
      case 13: $lJob = 'Job: Grass Mower'; break;
      case 14: $lJob = 'Job: Airport Worker'; break;
      case 15: $lJob = 'Job: Ammo Transporter'; break;
      case 16: $lJob = 'Job: Pilot'; break;
      case 17: $lJob = 'Job: Lawyer'; break;
  }

  //Status Server
  $online = mysqli_query($link, "SELECT count(*) as tc from players WHERE Status=1");
  $Online = mysqli_fetch_object($online)->tc;

  $online = mysqli_query($link, "SELECT count(*) as tc from players WHERE Status=1 AND Member=0");
  $CivOnline = mysqli_fetch_object($online)->tc;

  $online = mysqli_query($link, "SELECT count(*) as tc from players WHERE Status=1 AND (Admin>0 OR Helper>0)");
  $StaffOnline = mysqli_fetch_object($online)->tc;

  $online = mysqli_query($link, "SELECT count(*) as tc from players WHERE Admin>0 OR Helper>0");
  $StaffTotal = mysqli_fetch_object($online)->tc;

  $online = mysqli_query($link, "SELECT count(*) as tc from players WHERE DATE(`RegDate`) = CURDATE()");
  $RegToday = mysqli_fetch_object($online)->tc;

  $oplayers = '';
  $query = mysqli_query($link, "SELECT user, SkinID, Pid, Member FROM players WHERE Status=1");
  if(mysqli_num_rows($query)==0) $oplayers = 'Nu sunt jucatori online!</br>(0/500)';
  while($rr=mysqli_fetch_array($query))
  {
    switch($rr['Member'])
    {
      case 0: $col='#FFFFFF'; break;
      case 1: $col='#1269EB'; break;
      case 2: $col='#1710E0'; break;
      case 3: $col='#0600A8'; break;
      case 4: $col='#FF6347'; break;
      case 5: $col='#E8D71E'; break;
      case 6: $col='#D67ED5'; break;
      case 7: $col='#24E3CA'; break;
      case 8: $col='#2f2f2f'; break;
      case 9: $col='#009100'; break;
      case 10: $col='#910082'; break;
      case 11: $col='#E7EB8D'; break;
      case 12: $col='#FA021F'; break;
      case 13: $col='#2f2f2f'; break;
      case 14: $col='#EB4F00'; break;
      case 15: $col='#00A876'; break;
    }
    $oplayers .= '<a href="https://rpg.linkmania.ro/user/profile/'.$rr['user'].'" target="_blank" style="color:'.$col.';font-weight: bold;margin-right:10px;"><img src="img/a/'.$rr['SkinID'].'.png" style="color:white;border-radius:50%;height:35px;" alt=""/>'.$rr['user'].' ('.$rr['Pid'].')</a>';
  }

  $query = mysqli_query($link, "SELECT * FROM indexano");
  while($rr=mysqli_fetch_array($query))
  {
      $html = '<section class="bg-light page-section" id="portfolio">
        <div class="container">
          <div class="row"><div class="col-lg-12 text-center"><h2 class="section-heading text-uppercase">INFORMATII SI ANUNTURI</h2></div></div>
          <div class="row">
            <div class="col-md-4 col-sm-6 portfolio-item">
              <a class="portfolio-link" data-toggle="modal" href="#a'.$rr['ID'].'" id="viewed" sid="'.$rr['ID'].'">
                <div class="portfolio-hover">
                  <div class="portfolio-hover-content">
                    <i class="fas fa-plus fa-3x"></i>
                  </div>
                </div>
                <img class="img-fluid" src="'.$rr['ImgLink'].'" alt="Loading...">
              </a>
              <div class="portfolio-caption"><h4>'.$rr['Title'].'</h4><p>'.$rr['SecondTitle'].'</p><p id="date"><i class="fas fa-clock"></i> '.$rr['created_at'].' / by '.$rr['PostedBy'].'</p></div>
            </div>
          </div>
        </div>
        <hr>
        <h2 class="section-heading text-uppercase ann">JUCATORI ONLINE</h2>'.$oplayers.'</section>
      <div class="portfolio-modal modal fade" id="a'.$rr['ID'].'" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="close-modal" data-dismiss="modal">
              <div class="lr">
                <div class="rl"></div>
              </div>
            </div>
            <div class="container">
              <div class="row">
                <div class="col-lg-8 mx-auto">
                  <div class="modal-body">
                    <!-- Project Details Go Here -->
                    <h2 class="text-uppercase" style="color:white;">'.$rr['Title'].'</h2>
                    <p class="item-intro text-muted">'.$rr['SecondTitle'].'</p>
                    <img class="img-fluid d-block mx-auto" src="'.$rr['ImgLink'].'" style="border-radius:10%;" alt="Loading...">
                    <p>'.nl2br($rr['Text']).'</p>
                    <ul class="list-inline" style="float:right;">
                      <hr><li style="font-size:13px;"><img src="img/a/'.$rr['Skin'].'.png" style="border-radius:50%;height:38px;" alt=""/> <b style="vertical-align: bottom;display: inline-block;text-align: center;">'.$rr['PostedBy'].'</b></br></br><i class="fas fa-clock"></i> <b>'.$rr['created_at'].'</b></br><i class="fas fa-eye"></i> <b>'.$rr['Views'].'</b></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>';
  }
  mysqli_close($link);
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <script src="https://discordapp.com/api/guilds/479998712689590273/widget.json"></script>
  <title>Index Gaming</title>
  <link href="css/style.css" rel="stylesheet" type="text/css">
  <script src="js/chart.min.js"></script>
</head>

<body id="page-top">

  <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
    <div class="container">
      <a class="navbar-brand js-scroll-trigger" href="#page-top">LINKMANIA</a>
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        Menu
        <i class="fas fa-bars"></i>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav text-uppercase ml-auto">
          <li class="nav-item"><a class="nav-link lg" href="https://www.linkmania.ro/"><i class="fab fa-forumbee"></i> Forum</a></li>
          <li class="nav-item"><a class="nav-link lg" href="https://rpg.linkmania.ro/"><i class="fab fa-chromecast"></i> Panel</a></li>
          <li class="nav-item"><a class="nav-link lg js-scroll-trigger" href="#media"><i class="fab fa-android"></i> Media</a></li>
          <li class="nav-item"><a class="nav-link lg js-scroll-trigger" href="#portfolio"><i class="fab fa-affiliatetheme"></i> INFO</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <header class="masthead"><div class="container"><div class="intro-text"><font style="color:red;font-weight:bold;">Panelul o sa fie disponibil in totalitate la deschidere sau inaintea acesteia cu cateva zile!</font><canvas id="myChart" width="40" height="10"></div></div></header>

  <section class="page-section" id="services">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 text-center">
          <h2 class="section-heading text-uppercase an">Distractia este la ea acasa!</h2>
          <h3 class="section-subheading text-muted la" id="uTEXT">Eventurile mereu au fost o distractie la noi pe server.</h3>
        </div>
      </div>
      <div class="row text-center">
        <div class="col-md-2">
          <img class="zoom" src="img/a1.jpg" onclick="myFunction(this,1);">
          <img class="zoom" src="img/a2.jpg" onclick="myFunction(this,2);">
          <img class="zoom" src="img/a3.jpg" onclick="myFunction(this,3);">
          <img class="zoom" src="img/a4.jpg" onclick="myFunction(this,4);">
          <img class="zoom" src="img/a5.jpg" onclick="myFunction(this,5);">
          <img class="zoom" src="img/a6.jpg" onclick="myFunction(this,6);">
          <img class="zoom" src="img/a7.jpg" onclick="myFunction(this,7);">
        </div>
        <div class="col-md-7"><img id="expandedImg" src="img/a1.jpg"/></div>
        <div class="col-md-2"><img src="img/car1.png" style="height:450px;"/></div>
      </div>
    </div>
  </section>

  <section class="page-section" id="about">
    <div class="container">
      <div class="row"><div class="col-lg-12 text-center"><h2 class="section-heading text-uppercase">JOACA ACUM INCEPE...</h2></br></div></div>
      <div class="row">
        <div class="col-lg-12">
          <ul class="timeline">
            <li>
              <div class="timeline-image">
                <img class="rounded-circle img-fluid" src="img/about/1.png" alt="">
              </div>
              <div class="timeline-panel">
                <div class="timeline-heading">
                  <h4>NE JUCAM BILIARD?</h4>
                </div>
                <div class="timeline-body">
                  <p class="text-about">Barurile sunt mereu pline acum, majoritatea completand timpul lor liber la o masa de biliard cu prietenii...</p>
                </div>
              </div>
            </li>
            <li class="timeline-inverted">
              <div class="timeline-image">
                <img class="rounded-circle img-fluid" src="img/about/2.png" alt="">
              </div>
              <div class="timeline-panel">
                <div class="timeline-heading">
                  <h4>DROGURI IN CASA TA</h4>
                </div>
                <div class="timeline-body">
                  <p class="text-about">De acum esti mai liber, iti poti planta ghivece cu droguri chiar la tine in casa. Ai grija insa la politie...</p>
                </div>
              </div>
            </li>
            <li>
              <div class="timeline-image">
                <img class="rounded-circle img-fluid" src="img/about/3.png" alt="">
              </div>
              <div class="timeline-panel">
                <div class="timeline-heading">
                  <h4>JEFUIREA CASELOR</h4>
                </div>
                <div class="timeline-body">
                  <p class="text-about">Este prea riscant sa jefuiesti o banca dar vrei totusi sa te bucuri de bani multi? Alege saprgerea unei case din oras, verifica ca proprietarul sa nu fie acasa si fa-ti treaba!</p>
                </div>
              </div>
            </li>
            <li class="timeline-inverted">
              <div class="timeline-image">
                <img class="rounded-circle img-fluid" src="img/about/4.png" alt="">
              </div>
              <div class="timeline-panel">
                <div class="timeline-heading">
                  <h4>VREI SA TE FACI AUZIT?</h4>
                  <h4 class="subheading">ACUM EXISTA O POSIBILITATE</h4>
                </div>
                <div class="timeline-body">
                  <p class="text-about">Cumpara un billboard si fa-ti reclama cum sti tu mai bine, textul scris va fi afisat in format maxim pe panoul cumparat intrucat toti jucatorii sa-l poata vedea.</p>
                </div>
              </div>
            </li>
            <li>
              <div class="timeline-image">
                <img class="rounded-circle img-fluid" src="img/about/5.png" alt="">
              </div>
              <div class="timeline-panel">
                <div class="timeline-heading">
                  <h4>JOACA SA FIE JOACA...</h4>
                  <h4 class="subheading">CHEAMA-TI PRIETENII SI VENITI AICI</h4>
                </div>
                <div class="timeline-body">
                  <p class="text-about">Joaca-te aici cu prietenii tai sau alti jucatori si transforma distractia in sumele de bani pe care ti le doresti si care pot fi castigate de aici!</p>
                </div>
              </div>
            </li>
            <li class="timeline-inverted">
              <div class="timeline-image bgimgli2">
                <img class="rounded-circle img-fluid" src="img/s/Skin_<?php echo $row['SkinID']; ?>.png" style="height:100%;" alt="">
              </div>
              <div class="timeline-panel">
                <div class="timeline-heading">
                  <h4>ULTIMUL INREGISTRAT</br><u><?php echo $row['user']; ?></u></h4>
                </div>
                <div class="timeline-body">
                  <p class="text-about" style="display:inline-flex;">
                      Nivel: <?php echo $row['Score']; ?>
                      </br>RP: <?php echo $row['RPoints']; ?>/<?php echo $row['Score']*3; ?>
                      </br>Ore jucate: <?php echo number_format($row['HoursPlayed']/3600, 2); ?>
                      </br><?php echo $lJob; ?>
                      </br>Data: <?php echo $row['RegDate']; ?><a href="https://rpg.linkmania.ro/user/profile/<?php echo $row['user']; ?>" target="_blank" class="rainbow-button" alt="PANEL PROFILE"></a>
                  </p>
                </div>
              </div>
            </li>
            <li class="timeline">
              <div class="timeline-image bgimgli3"><h4></br><b>STATUS SERVER</b></h4></div>
              <div class="timeline-panel">
                <div class="timeline-body">
                  <p class="text-about" style="display:inline-flex;">
                      Online: <?php echo $Online; ?>/500
                      </br>Civili online: <?php echo $CivOnline; ?>/<?php echo $Online; ?>
                      </br>Staff online: <?php echo $StaffOnline; ?>/<?php echo $StaffTotal; ?>
                      </br>Total conturi: <?php echo $row['ID']; ?>
                      </br>Inregistrati astazi: <?php echo $RegToday; ?><a id="ipHR" onclick="copyIP('193.203.39.215:7777')" class="rainbow-button" style="color:white;" alt="COPY SERVER IP"></a>
                  </p>
                </div>
              </div>
            </li>
            <li class="timeline-inverted"><div class="timeline-image bgimgli"><h4><b>PARTICIPA<br>LA<br>DISTRACTIE</b></h4></div></li>
          </ul>
        </div>
      </div>
    </div>
  </section>

  <section class="page-section" id="media">
    <div class="container">
      <div class="row"><div class="col-lg-12 text-center"><h2 class="section-heading text-uppercase">MEDIA</h2></div></div>
      <div class="pagination-centered">
        <div class="card" style="background-color:#3b5998;color:white;">
          <div class="card-body text-center">
            <p class="card-text"><img src="img/fl.png"></br>Esti mereu la "curent" cu ultimele noutati de pe server pe pagina noastra de FaceBook!</br>Da-ne si tu un <b>like</b>, promitem sa nu te dezamagim.</p>
            <div class="mediat">
                <a href="https://www.facebook.com/linkmaniasamp/" target="_blank"><i class="fab fa-facebook" style="font-size:30px;" aria-hidden="true"></i><span class="badge badge-success">+1.700 Likes</span><span><b>Facebook</b></span></a>
            </div>
          </div>
        </div>
        </br><div class="card" style="background-color:#c4302b;color:white;">
          <div class="card-body text-center">
            <p class="card-text"><img src="img/yl.png"></br>Avem si un canal nou de YouTube unde urmeaza sa postam diverse videoclipuri de pe serverul nostru.</br>Daca vrei sa fii in ton cu distractia nu ezita sa ne dai un <b>subscribe</b> si aici!</p>
            <div class="mediat">
              <a href="https://www.youtube.com/channel/UCeNcUq5qKcje39Q4pkhiHPQ/videos" target="_blank"><i class="fab fa-youtube" style="font-size:30px;" aria-hidden="true"></i><span class="badge badge-success">+7 Subscr.</span><span><b>YouTube</b></span></a>
            </div>
          </div>
        </div>
      </div>
      </br><div class="card" style="background-color:#1c1c1c;color:white;">
          <div class="card-body text-center">
            <p class="card-text"><img src="img/dw.png"></br>Serverul nu este lipsit nici de un server propriu de Discord pe care poti intra si tu.</br>Haide si tu, abia asteptam sa te auzim!</p>
            <iframe src="https://discordapp.com/widget?id=479998712689590273&theme=dark" width="220" height="300" allowtransparency="true" frameborder="0"></iframe>
          </div>
        </div>
      </div>
    </div>
  </section>

  <footer class="footer">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-4"><span class="copyright">Created from <i class="fa fa-heart" style="color:red;"></i> by Spoker / &copy; LinkMania 2020</span></div>
      </div>
    </div>
  </footer>
  <script src="js/js.min.js"></script>
</body>
</html>

<script>
function copyIP(value) {
    document.getElementById('ipHR').setAttribute('alt', 'IP COPIED!');
    document.getElementById('ipHR').setAttribute('style', 'color:#c4302b;');
    var tempInput = document.createElement("input");
    tempInput.style = "position: absolute; left: -1000px; top: -1000px";
    tempInput.value = value;
    document.body.appendChild(tempInput);
    tempInput.select();
    document.execCommand("copy");
    document.body.removeChild(tempInput);
}
function myFunction(imgs, test) {
  switch(test)
  {
      case 1: document.getElementById("uTEXT").innerHTML='Eventurile mereu au fost o distractie la noi pe server.'; break;
      case 2: document.getElementById("uTEXT").innerHTML='Gang vs. Politie, mereu intr-o actiune continua...'; break;
      case 3: document.getElementById("uTEXT").innerHTML='Excursiile nu sunt nici ele excluse din context.'; break;
      case 4: document.getElementById("uTEXT").innerHTML='Mapele facute special pentru eventuri sunt o specialitate la care adminii sunt mereu inventivi.'; break;
      case 5: document.getElementById("uTEXT").innerHTML='Team vs. Team, inca o distractie pentru jucatori.'; break;
      case 6: document.getElementById("uTEXT").innerHTML='Eventurile race, cui nu-i plac...?'; break;
      case 7: document.getElementById("uTEXT").innerHTML='NU... MISCA!'; break;
  }
  var expandImg = document.getElementById("expandedImg"), imgText = document.getElementById("imgtext");
  expandImg.src = imgs.src;
  imgText.innerHTML = imgs.alt;
  expandImg.parentElement.style.display = "block";
}
$("#viewed").click(function()
{
    $.ajax({
        type: "POST",
        data: { "sad": $(this).attr('sid') },
        url: "update_value.php"
    });
});
var ctx = document.getElementById('myChart').getContext('2d');var myChart = new Chart(ctx, {type: 'line', data: {labels: <?php echo json_encode($data);?>, datasets: [ {label: 'Players Graph', data: <?php echo json_encode($players);?>, backgroundColor: 'rgba(0,0,0,0)', borderColor: '#ff0062',}]},options: {legend: {labels: {fontColor: 'white'}},scales: {yAxes: [{ticks: {beginAtZero: true,fontColor: 'white',}}],xAxes: [{ticks: {fontColor: 'white'},}]}}});
</script>