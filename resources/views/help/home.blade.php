@extends('layouts.app')

@section('content')
<section id="help">
    <v-section name="home">
        <div class="row w-100">
            <div class="col-4">
              <div class="list-group" id="list-tab" role="tablist">
                <a class="list-group-item list-group-item-action active" data-toggle="list" href="#list-article" role="tab">Article</a>
                <a class="list-group-item list-group-item-action" data-toggle="list" href="#list-category" role="tab">Category</a>
                <a class="list-group-item list-group-item-action" data-toggle="list" href="#list-layout" role="tab">Layout</a>
                <a class="list-group-item list-group-item-action" data-toggle="list" href="#list-mainMenu" role="tab">Main Menu</a>
                <a class="list-group-item list-group-item-action" data-toggle="list" href="#list-user" role="tab">User</a>
                <a class="list-group-item list-group-item-action" data-toggle="list" href="#list-visibility" role="tab">Visibility</a>                
              </div>
            </div>
            <div class="col-8">
              <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="list-article" role="tabpanel" aria-labelledby="list-article-list">
                    <a href="#article">Articles</a> are linked to <a href="#category">categories</a>, when creating a new article you must define properties such as 
                    <a href="#layout">layout</a> and <a href="#visibility">visibility</a>, but these can be receive by  
                    <a href="#category">categories</a>. <br/><br/><a href="#article">keep reading</a>
                </div>
                <div class="tab-pane fade" id="list-category" role="tabpanel" aria-labelledby="list-messages-list">
                    All <a href="#category">categories</a> are used by default to set up the <a href="#mainmenu">main menu</a>. 
                    It is important to inform whether you want this behavior. Other related elements are the 
                    <a href="#icon">icon</a> and <a href="#layout">color</a>.<br/>
                    See also <a href="#layout">layout</a> and <a href="#visibility">visibility</a>.
                    <br/><br/><a href="#category">keep reading</a>
                </div>
                <div class="tab-pane fade" id="list-layout" role="tabpanel" aria-labelledby="list-layout-list">
                    <a href="#layout">Layout</a> is an exclusive behavior of the home. 
                    Through it it is possible to configure the default behavior of each <a href="#article">article</a>.                    
                    <br/><br/><a href="#layout">keep reading</a>
                </div>
                <div class="tab-pane fade" id="list-mainMenu" role="tabpanel" aria-labelledby="list-layout-list">
                    The <a href="#mainmenu">main menu</a> is a dynamic item for everywere in the website. 
                    It is assembled from the <a href="#category">categories</a>, has its behavior and 
                    <a href="#color">color</a> changed to enhance the user's experience. <br/><br/><a href="#mainmenu">keep reading</a>             
                </div>                
                <div class="tab-pane fade" id="list-user" role="tabpanel" aria-labelledby="list-home-list">
                    Users are within three levels. They are: User, Publisher and Admin. <br/><br/><a href="#user">keep reading</a>
                </div>                
                <div class="tab-pane fade" id="list-visibility" role="tabpanel" aria-labelledby="list-visibility-list">
                    The <a href="#visibility">visibility</a> controls who can see an 
                    <a href="#article">article</a>, through it you can inform if the 
                    <a href="#article">article</a> is public, private, and others.
                    <br/><br/><a href="#visibility">keep reading</a>             
                </div>                
              </div>
            </div>
          </div>        
    </v-section>
    <v-section name="article">
        <h2>Article</h2>
        <div class="row w-100">        
            <div class="col-4">
                <div class="list-group" id="list-tab" role="tablist">
                <a class="list-group-item bg-primary text-white">Properties</a>
                <a class="list-group-item"></a>
                <a class="list-group-item list-group-item-action" data-toggle="list" href="#list-article-title" role="tab">Title</a>
                <a class="list-group-item list-group-item-action" href="#category" role="tab">Category</a>
                <a class="list-group-item list-group-item-action" href="#layout" role="tab">Details: Layout</a>
                <a class="list-group-item list-group-item-action" href="#visibility" role="tab">Details: Visibility</a>
                <a class="list-group-item list-group-item-action" data-toggle="list" href="#list-article-content" role="tab">Content</a>                
                </div>
            </div>
          <div class="col-8">
            <div class="tab-content" id="nav-tabContent">
              <div class="tab-pane fade show active" id="list-article" role="tabpanel" aria-labelledby="list-article-list">
                <p>All content is based on articles.</p>
                <p>When creating a new one you must make sure that all properties are in accordance with what you want.
                To avoid unusual behaviors try using the visibility property as unlisted, 
                so you can highlight an article before publishing it.</p>
              </div>
              <div class="tab-pane fade" id="list-article-title" role="tabpanel" aria-labelledby="list-messages-list">
                <p>The title will be converted into a tag like: h1, h2, ...; For better display. </p>
                <p>It's will always be saved in minuscule.</p>
              </div>
              <div class="tab-pane fade" id="list-article-content" role="tabpanel" aria-labelledby="list-layout-list">
                <p>To create a content, a <a href="https://www.tiny.cloud" target="_new">tinymce</a> type editor is used, read the documentation for a better understanding.</p>
                <p>It is not enabled image storage within the system for this it is necessary to use a third party service according to your desire.</p>
              </div>               
            </div>
          </div>
        </div>          
    </v-section>
    <v-section name="category">
        <h2>Category</h2>
        <div class="row w-100">        
            <div class="col-4">
                <div class="list-group" id="list-tab" role="tablist">
                    <a class="list-group-item bg-primary text-white">Properties</a>
                    <a class="list-group-item"></a>
                    <a class="list-group-item list-group-item-action" data-toggle="list" href="#list-category-name" role="tab">Name</a>
                    <a class="list-group-item list-group-item-action" href="#icon" role="tab">Icon</a>
                    <a class="list-group-item list-group-item-action" href="#layout" role="tab">Layout</a>
                    <a class="list-group-item list-group-item-action" href="#visibility" role="tab">Visibility</a>
                    <a class="list-group-item list-group-item-action" data-toggle="list" href="#list-category-isMenu" role="tab">is menu</a>  
                    <a class="list-group-item list-group-item-action" data-toggle="list" href="#list-category-color" role="tab">color</a>
                </div>
            </div>
          <div class="col-8">
            <div class="tab-content" id="nav-tabContent">
              <div class="tab-pane fade show active" id="list-article" role="tabpanel" aria-labelledby="list-article-list">
                <p>Category and a collection of articles. Also a category for being a main menu item.</p>
                <p>Its properties are mixed and a correct registration and configuration is necessary.</p>
              </div>
              <div class="tab-pane fade" id="list-category-name" role="tabpanel" aria-labelledby="list-messages-list">
                <p>Use short names that summarize the set of articles involved.</p>
              </div>
              <div class="tab-pane fade" id="list-category-isMenu" role="tabpanel" aria-labelledby="list-layout-list">
                <p>If you do not want the category to be displayed in the main menu, you must disable it.</p>
                <p>This property does not change the visibility property, so the behavior of the category in the home will be maintained.</p>
              </div>   
              <div class="tab-pane fade" id="list-category-color" role="tabpanel" aria-labelledby="list-layout-list">
                <p>The color of the category is related to the display color of the main menu, when the category is in focus.</p>
                <p>It is also used for the tags next to each article on the home page. This can be seen within the example next to the color property</p>
              </div>            
            </div>
          </div>
        </div>          
    </v-section>    
    <v-section name="layout">
        <h2>Layout</h2>
        <div class="row w-100">        
            <div class="col-4">
                <div class="list-group" id="list-tab" role="tablist">
                    <a class="list-group-item bg-primary text-white">Models</a>
                    <a class="list-group-item"></a>
                    <a class="list-group-item list-group-item-action" data-toggle="list" href="#list-layout-general" role="tab">General</a>
                    <a class="list-group-item list-group-item-action" data-toggle="list" href="#list-layout-cols" role="tab">Cols</a>
                </div>
            </div>
          <div class="col-8">
            <div class="tab-content" id="nav-tabContent">
              <div class="tab-pane fade show active" id="list-article" role="tabpanel" aria-labelledby="list-article-list">
                <p>Layout and the way the home page will display each article. by pattern: general</p>
              </div>
              <div class="tab-pane fade" id="list-layout-general" role="tabpanel" aria-labelledby="list-messages-list">
                <p>Standard layout, it will not change anything in the article.</p>
                <img src="{{asset('/help_img/layout-general.png')}}" class="img w-100" />
              </div>         
              <div class="tab-pane fade" id="list-layout-cols" role="tabpanel" aria-labelledby="list-messages-list">
                <p>This layout uses part of the article and also changes the size of the images.</p>
                <p>Converts the display into columns placing up to 3 articles side by side.</p>
                <img src="{{asset('/help_img/layout-cols.png')}}" class="img w-100" />
              </div>                       
            </div>
          </div>
        </div>   
    </v-section>
    <v-section name="mainmenu">
        <h2>Main Menu</h2>
        <div class="row w-100">        
            <div class="col-4">
                <div class="list-group" id="list-tab" role="tablist">
                    <a class="list-group-item bg-primary text-white">Behaviors</a>
                    <a class="list-group-item"></a>
                    <a class="list-group-item list-group-item-action" data-toggle="list" href="#list-mainmenu-home" role="tab">Home Page</a>
                    <a class="list-group-item list-group-item-action" data-toggle="list" href="#list-mainmenu-article" role="tab">Category and Article Pages</a>
                </div>
            </div>
          <div class="col-8">
            <div class="tab-content" id="nav-tabContent">
              <div class="tab-pane fade show active" id="list-article" role="tabpanel" aria-labelledby="list-article-list">
                <p>On scrolling the page, it`s fixed at the top.</p>
              </div>
              <div class="tab-pane fade" id="list-mainmenu-home" role="tabpanel" aria-labelledby="list-messages-list">
                <p>Detecting which each category is showing its color to adapt to each category. 
                    When clicked on the link it scrolls to the category.</p>
              </div>         
              <div class="tab-pane fade" id="list-mainmenu-article" role="tabpanel" aria-labelledby="list-messages-list">
                <p>When clicked on the link it load the page with the category.</p>
              </div>                       
            </div>
          </div>
        </div> 
    </v-section>
    <v-section name="user">
        <h2>User</h2>
        <div class="row w-100">        
            <div class="col-4">
                <div class="list-group" id="list-tab" role="tablist">
                    <a class="list-group-item bg-primary text-white">Level</a>
                    <a class="list-group-item"></a>
                    <a class="list-group-item list-group-item-action active" data-toggle="list" href="#list-user-user" role="tab">User</a>
                    <a class="list-group-item list-group-item-action" data-toggle="list" href="#list-user-publisher" role="tab">Publisher</a>
                    <a class="list-group-item list-group-item-action" data-toggle="list" href="#list-user-admin" role="tab">Admin</a>
                </div>
            </div>
          <div class="col-8">
            <div class="tab-content" id="nav-tabContent">
              <div class="tab-pane fade show active" id="list-user-user" role="tabpanel" aria-labelledby="list-article-list">
                <p>Default to registration.</p>
                <p>Allows access to non-public content.</p>
              </div>
              <div class="tab-pane fade" id="list-user-publisher" role="tabpanel" aria-labelledby="list-messages-list">
                <p>Allows you to create categories and articles. Can also edit or exclude them.</p>
              </div>         
              <div class="tab-pane fade" id="list-user-admin" role="tabpanel" aria-labelledby="list-messages-list">
                <p>Allows you to create categories and articles. Can also edit or exclude them.</p>
                <p>It also allows users to change their permissions.</p>
              </div>                       
            </div>
          </div>
        </div> 
    </v-section>    
    <v-section name="visibility">
        <h2>Visibility</h2>
        <div class="row w-100">        
            <div class="col-4">
                <div class="list-group" id="list-tab" role="tablist">
                    <a class="list-group-item bg-primary text-white">Characteristics</a>
                    <a class="list-group-item"></a>
                    <a class="list-group-item list-group-item-action" data-toggle="list" href="#list-visibility-public" role="tab">public</a>
                    <a class="list-group-item list-group-item-action" data-toggle="list" href="#list-visibility-parciallypublic" role="tab">partially public</a>
                    <a class="list-group-item list-group-item-action" data-toggle="list" href="#list-visibility-unlisted" role="tab">unlisted</a>
                    <a class="list-group-item list-group-item-action" data-toggle="list" href="#list-visibility-private" role="tab">private</a>
                    <a class="list-group-item list-group-item-action" data-toggle="list" href="#list-visibility-notpublished" role="tab">not published</a>
                </div>
            </div>
          <div class="col-8">
            <div class="tab-content" id="nav-tabContent">
              <div class="tab-pane fade show active" role="tabpanel" aria-labelledby="list-article-list">
                <p>Visibility controls who can see their articles.</p>
              </div>
              <div class="tab-pane fade" id="list-visibility-public" role="tabpanel" aria-labelledby="list-messages-list">
                <p>No registration required to access.</p>
              </div>         
              <div class="tab-pane fade" id="list-visibility-parciallypublic" role="tabpanel" aria-labelledby="list-messages-list">
                <p>It allows public access to up to 30% of the content, includes a button type <i>read more</i> to access all.</p>
                <p>Only be able to access all content after registration.</p>
              </div>          
              <div class="tab-pane fade" id="list-visibility-unlisted" role="tabpanel" aria-labelledby="list-messages-list">
                <p>It does not require registration.</p>
                <p>However it is not indexed on any page.</p>
              </div>
              <div class="tab-pane fade" id="list-visibility-private" role="tabpanel" aria-labelledby="list-messages-list">
                <p>Registration is require</p>
                <p>It`s hidden on the home page and is only displayed after login.</p>
              </div>    
              <div class="tab-pane fade" id="list-visibility-notpublished" role="tabpanel" aria-labelledby="list-messages-list">
                <p>It's not displayed at any time</p>
                <p>Can only be accessed through the panel.</p>
              </div>                          
            </div>
          </div>
        </div> 
    </v-section>      
    <v-section name="icon">
        <h3>Icon</h3>
        <div class="w-100">
            <p>We use icons based on https://fontawesome.com/icons and Bootstrap 4</p>
            <p>when accessing the website you can select the icon copy it and paste it into the icon field.<br/>
            The system will automatically configure it and display it from the side.</p>
            
            <br />
            <p class="bg-secondary text-white p-3">
            <u>SELECT ICON</u>
            <img src="{{asset('/help_img/icon-select.png')}}" class="img w-100" />
            </p>

            <br/>
            <p class="bg-secondary text-white p-3">
            <u>COPY ICON</u>
            <img src="{{asset('/help_img/icon-copy.png')}}" class="img w-100" />
            </p>

            <br/>
            <p class="bg-secondary text-white p-3">
            <u>PAST ICON</u>
            <img src="{{asset('/help_img/icon-past.png')}}" class="img w-100" />
            <p>
            
        </div>
    </v-section>
</section>
@endsection