<style>
  #calendar {
    width: 100%;
    margin: 0 auto;
    font-size: 10px;
  }

  .fc-header-title h2 {
    font-size: .9em;
    white-space: normal !important;
  }

  .fc-view-month .fc-event,
  .fc-view-agendaWeek .fc-event {
    font-size: 0;
    overflow: hidden;
    height: 2px;
  }

  .fc-view-agendaWeek .fc-event-vert {
    font-size: 0;
    overflow: hidden;
    width: 2px !important;
  }

  .fc-agenda-axis {
    width: 20px !important;
    font-size: .7em;
  }

  .fc-button-content {
    padding: 0;
  }
  .thumbnail:hover {
  border-color: red
}
</style>
<section class="container main-container">
  <div class="row" style="margin-top: 20px">
    <div class="col-md-7">
      <?php include(WWW_VIEW . "Themes/{$this->getPage('theme')}/Layouts/sections/slide.php"); ?>
    </div>
    <div class="col-md-5 div-border-side">
      <div class="activity-header">
        <b class="font-detail-18">ปฏิทินกิจกรรม</b>
      </div>
      <div class="text-centet" style="margin: 15px; padding: 15px 0px;background-color: #f1f1f1;">
        <div id="calendar" style="height: 250px; width:300px;"></div>
      </div>

      <div class="list-activity-all">
        <a href="#" class="pull-right btn btn-danger btn-sm">ดูเพิ่มเติม</a>
      </div>
    </div>
  </div>
  <div class="row margin-top15">
    <section class="container">
      <div class="row">
        <div class="col-md-3">
          <div class="panel" style="display: block">
            <div class="panel-header-rmutl">
              <i class="icon-navicon fa-fw linkss-icon-style"></i>
              <span class="big-header-link">TETC</span> <span class="sub-header-link">ลิงค์</span>
              <a href="" title="บทความ">
                <i class="icon-angle-double-right fa-fw pull-right links-arrow"></i>
              </a>
            </div>
            <div class="panel-body-rmutl">
              <img src="<?= VIEW ?>Themes/<?= $this->getPage('theme') ?>/assets/images/logolink.jpg" class="img-responsive">
              <ul class="link-rmutl nav nav-pills nav-stacked">
                <li class="dim-li">
                  <a target="_blank" href="http://www.itech.lpru.ac.th/">
                    <i class="fas fa-building mr10"></i>คณะเทคโนโลยีอุตสาหกรรม </a>
                </li>
                <li>
                  <a target="_blank" href="https://www.lpru.ac.th/" target="_blank">
                    <i class="icon-university mr10"></i>มหาวิทยาลัยราชภัฏลำปาง </a>
                </li>
              </ul>
            </div>
          </div>
          
          <div class="panel" style="display: block">
            <div class="panel-header-rmutl">
              <i class="fas fa-handshake fa-fw linkss-icon-style"></i>
              <span class="sub-header-link">องค์กรภายใต้ความร่วมมือ (MOU)</span>
            </div>
            <div class="panel-body-rmutl">
              <img src="<?= VIEW ?>Themes/<?= $this->getPage('theme') ?>/assets/images/appliCAD.png" class="thumbnail img-responsive">
            </div>
            <div class="panel-body-rmutl">
              <img src="<?= VIEW ?>Themes/<?= $this->getPage('theme') ?>/assets/images/auto didactic.png" class="thumbnail img-responsive">
            </div>
            <div class="panel-body-rmutl">
              <img src="<?= VIEW ?>Themes/<?= $this->getPage('theme') ?>/assets/images/3.png" class="thumbnail img-responsive">
            </div>
          </div>
      
        </div>
        <div class="tab-content-post-8col col-md-9">
          <?php include("sections/news.php"); ?>
        </div>
      </div>
    </section>
    <section class="container">
      <div class="row">
        
      </div>
    </section>
  </div>
  <div id="content" class="mtm">
    <?php include("sections/news-footer.php"); ?>
  </div>
</section>
<input type="hidden" id="last_tab" value="1">
<script>
  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
      timeZone: 'local',
      plugins: ['dayGrid'],
      locale: 'th',
      // events: 'calendar.php',
      header: {
        left: 'today',
        center: 'title',
        right: 'prev,next'
      },
      buttonText: {
        today: 'วันนี้',
        month: 'เดือน',
        week: 'สัปดาห์',
        day: 'วัน',
        list: 'รายการ'
      }
    });
    calendar.render();
  });
</script>