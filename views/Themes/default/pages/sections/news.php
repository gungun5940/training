<div class="tab-content-post">
   <div id="carousel3" class="owl-carousel nxt tab-category text-center owl-mos" style="display: block; opacity: 1;font-weight: bold;">
      <?php
      $c = 0;
      foreach ($this->newsType as $key => $value) {
         $c++;
         echo '<a id="tab_'.$c.'" data-id="'.$value['id'].'" class="owl-item-a">'.$value['name'].'</a>';
      }
      ?>
   </div>
   <div id="newsLists"></div>
</div>
<script type="text/javascript">
   $(document).ready(function () {
      var i = 1;
      $('#carousel3 a').each(function () {
         if (i == 1) {
            $('#tab_' + i).parent().addClass('active-owl-item');
            $('#tab_' + i).addClass('active-owl-item-a')
         }
         $('#tab_' + i).parent().attr('onclick', 'goactive(' + i + '); removemouseover(' + i + ');');
         $('#tab_' + i).parent().attr('onmouseover', 'hovertabs(' + i + ');');
         $('#tab_' + i).parent().attr('onmouseout', 'outtabs(' + i + ');');
         $('#tab_' + i).parent().attr('aria-controls', 'tab_' + i);
         $('#tab_' + i).parent().attr('role', 'tab');
         $('#tab_' + i).parent().attr('data-toggle', 'tab');
         $('#tab_' + i).parent().attr('href', '#tab_' + i);
         i++
      })

      $('#carousel3').find(".owl-item").click(function(){
         $.fn.loadNewsLists( $(this).find('a').data("id") );
      });

      $.fn.loadNewsLists( $(".active-owl-item").find("a").data("id") );
   });
   
   function goactive(i) {
      $('#tab_' + $('#last_tab').val()).parent().removeClass('active-owl-item');
      $('#tab_' + $('#last_tab').val()).removeClass('active-owl-item-a');
      $('#tab_' + $('#last_tab').val()).parent().addClass('owl-item');
      $('#tab_' + $('#last_tab').val()).addClass('owl-item-a');
      $('#last_tab').val(i);
      $('#tab_' + i).parent().addClass('active-owl-item');
      $('#tab_' + i).addClass('active-owl-item-a')
   }
   function hovertabs(i) {
      if (!$('#tab_' + i).hasClass('active-owl-item-a')) {
         $('#tab_' + i).addClass('hover-owl-item-a')
      }
   }
   
   function outtabs(i) {
      $('#tab_' + i).removeClass('hover-owl-item-a')
   }
   
   function removemouseover(i) {
      $('#tab_' + i).removeClass('hover-owl-item-a')
   }

   $('#carousel1').owlCarousel({
      items: 9,
      autoPlay: 3000,
      lazyLoad: !0,
      navigation: !0,
      navigationText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
      pagination: !0
   });
   $('#carousel2').owlCarousel({
      items: 9,
      autoPlay: 3000,
      lazyLoad: !0,
      navigation: !0,
      navigationText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
      pagination: !0
   });
   $('#carousel3').owlCarousel({
      items: 5,
      lazyLoad: !0,
      navigation: !0,
      navigationText: ['<i class="fa fa-angle-left fa-modify"></i>', '<i class="fa fa-angle-right fa-modify"></i>'],
      pagination: !1
   });

   $.fn.loadNewsLists = function( id ){
      $("#newsLists").html( '<div class="tac"><div class="loader-spin-wrap" style="display:inline-block;"><div class="loader-spin"></div></div></div>' );
      $.get( Event.URL + 'news/loadIndex/' + id, function (html) {
         $("#newsLists").html( html );
      });
   }
</script>