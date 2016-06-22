
<!DOCTYPE html>
<html>
    <head>
         
        <link href='https://d6xfpzo6h49n1.cloudfront.net/hpN0Lj5NpvcKh1jKR1xWRs3hOeo=/16x16/https://teachable.com/images/favicons/favicon.ico' rel='shortcut icon'>
        <link href='//d6xfpzo6h49n1.cloudfront.net/hpN0Lj5NpvcKh1jKR1xWRs3hOeo=/16x16/https://teachable.com/images/favicons/favicon.ico' rel='apple-touch-icon'>

        <link rel="stylesheet" href='https://d2oz8i5n9se8ej.cloudfront.net/school-css-1465121490-59193-df956d74750189ec00814a3488dabbaf.css' />
        <link rel="stylesheet" href='https://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css' />
        <link rel="stylesheet" href='https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.css' />

      
      <meta charset="UTF-8">

      <title>{% block title %}{% endblock %} | Outgrow</title>
      
      <meta name="description" content="eBooks are old. Get the new!" />
      <link rel="canonical" href="http://outgrow.teachable.com/courses/lead-generation-with-interactive-calculators/lectures/1105813" />
      <meta property="og:title" content="New Lecture" />
      <meta property="og:url" content="http://outgrow.teachable.com/courses/lead-generation-with-interactive-calculators/lectures/1105813" />
      <meta property="og:description" content="eBooks are old. Get the new!" />
      <meta name="site_title" content="Outgrow" />
      
      <script src='https://fast.wistia.com/assets/external/E-v1.js'></script>
      <script src="https://d2oz8i5n9se8ej.cloudfront.net/assets/application-153673c214489fa9a177aafda95bf1793095739684143c861b6e4ba0c86048bc.js" data-turbolinks-track="true"></script>


      <no-conversion-pixels></no-conversion-pixels>
      <meta http-equiv="X-UA-Compatible" content="IE=edge">

    </head>

    <body data-no-turbolink="true">
      <meta http-content='IE=Edge' http-equiv='X-UA-Compatible'>
      <meta content='width=device-width,initial-scale=1.0,user-scalable=no' name='viewport'>
      <meta id="fedora-keys" data-env="production" data-stripe="pk_live_hkgvgSBxG4TAl3zGlXiB1KUX" />
      <meta id="fedora-data" data-id="1567931" data-name="Pratham Mittal" data-email="doscopratham@gmail.com" data-school-id="59193" data-src="null" data-joined-at="&quot;2016-06-05T09:27:42Z&quot;" data-wistia-identifier="59193:student:1567931" data-report-card="{&quot;76363&quot;:{&quot;course_id&quot;:76363,&quot;days_enrolled&quot;:1,&quot;percent_complete&quot;:0,&quot;class_period_id&quot;:null,&quot;completed_lecture_count&quot;:0,&quot;completed_lecture_ids&quot;:[]}}" data-course-ids="[76363]" data-role="owner" data-completed-lecture-ids="[]" data-school-id="59193" data-school-launched="true" data-preview="logged_out" data-turn-off-fedora-branding="false" data-plan-supports-whitelabeling="false" data-powered-by-text="Powered by" data-drip-enabled="false" data-asset-path="//https://d2oz8i5n9se8ej.cloudfront.net/assets/footer/teachable-logo-white-efd32576079839534d5b6e87bf4424e99b12624f854b2c500a4d3f0b6e2af46b.svg" data-course-id="76363" data-course-url="http://outgrow.teachable.com/courses/lead-generation-with-interactive-calculators" data-lecture-id="1105813" data-lecture-url="http://outgrow.teachable.com/courses/lead-generation-with-interactive-calculators/lectures/1105813" /><meta id="analytics-keys" name="analytics" data-analytics="{}" />

      {{ include('header.php') }}

      {{ include('sidebar.php') }}

      {% block content %}
      {% endblock %}


      <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.js"></script>
      <script type="text/javascript">
        $(document).ready(function() {
          
          // ajax to load chapters
          $('.lecture-path').on('click', function(e) {
            e.preventDefault();

            var path = $(this).data('path');
            var url = $(this).attr('href');
            var that = $(this);

            setPreviousContinueLinks(that);

            getChapter(url, that, 'push');
          });

          // on pop state - handle urls
          window.onpopstate = function(event) {
            var state = event.state;
            if(state){
              if(state === null || state.type === undefined)
                window.location.replace(document.location);

              if(state.type === 'chapters')
                getChapter(state.url, $('#' + state.attr), 'pop');
            }
          };

        });

        function getChapter(url, elem, type) {
          console.log(url+" "+elem+" "+type);
          $.ajax({
            type: 'get',
            url: url,
            dataType: 'json',
            beforeSend: function() {
              NProgress.start();
            },
            success: function(response) {
              if(response.success) {
                $('.chapter-holder').html(response.template);

                $('.lecture-path').removeClass('current');
                elem.addClass('current');

                if(type === 'push') {
                  var state = { type: 'chapters', url: url, attr: elem.attr('id') };
                  history.pushState(state, null, url);
                }

                document.title = response.title + " | Outgrow";
                NProgress.done();
              }
            },
            error: function() {
              console.log('Something went wrong!');
              NProgress.done();
            }
          });
        }

        function setPreviousContinueLinks(elem){
          var previousButton = $("#lecture_previous_button");
          var nextButton     = $("#lecture_complete_button");

          var isSidebarLink  = elem.attr("data-sidebar-link");
          
          if(isSidebarLink == "false"){
            elem = $('a[data-path="'+elem.attr("data-path")+'"][data-sidebar-link="true"]');
          }

          var parent        = elem.closest('.next-lecture');
          var previous      = parent.prev();
          var previousChild = previous.find(".lecture-path");

          var next          = parent.next();
          var nextChild     = next.find(".lecture-path");

          previousButton.attr("data-path", "introduction");
          previousButton.attr("href", "/resources/lead-generation-with-calculators/ebook/chapter/introduction");

          nextButton.attr("data-path", "final-thoughts");
          nextButton.attr("href", "/resources/lead-generation-with-calculators/ebook/chapter/final-thoughts");
          
          if(elem.attr('data-path') != "introduction"){
            previousButton.attr("data-path", previousChild.attr('data-path'));
            previousButton.attr("href", previousChild.attr('href'));
          }

          if(elem.attr('data-path') != "final-thoughts"){
            nextButton.attr("data-path", nextChild.attr('data-path'));
            nextButton.attr("href", nextChild.attr('href'));
          }

        }
      </script>

  </body>
</html>
