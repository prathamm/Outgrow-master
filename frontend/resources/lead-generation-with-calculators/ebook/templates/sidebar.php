<div class="course-sidebar lecture-page collapse navbar-collapse navbar-sidebar-collapse" id="courseSidebar" aria-expanded="false">
    <h2>Lead Generation With Interactive Calculators</h2>
    
      <!-- Lecture list on courses page (enrolled user) -->

      <div class="row lecture-sidebar">
        
        <div class="col-sm-12 course-section">
          <div class="section-title" data-days-until-dripped="0" data-course-id="76363">
            <span class="section-lock">
              <i class="fa fa-lock"></i>&nbsp;
            </span>
            Introduction
          </div>
          <ul class="section-list" data-total-count="{{ chapters|length }}">
            
            {% set count = 1 %}
            {% for key in chapters|keys %}
                <li class="section-item completed next-lecture">
                  <a class="item lecture-path" id="lecture-{{key}}" data-path="{{ key }}" data-count={{count}} href="{{ path_for('chapter', {'path': key}) }}" data-sidebar-link="true" data-no-turbolinks="" id="sidebar_link_1105813">
                    <span class="status-container">
                      <span class="status-icon">
                        &nbsp;
                      </span>
                    </span>
                    <div class="title-container">
                      <span class="lecture-icon">
                        <i class="fa fa-file-text"></i>
                      </span>
                      <span class="lecture-name">
                        {{ chapters[key]['name'] }}
                      </span>
                    </div>
                  </a>
            </li>
              {% set count = count + 1 %}
            {% endfor %}
            
          </ul>
        </div>
        
      </div>
</div>