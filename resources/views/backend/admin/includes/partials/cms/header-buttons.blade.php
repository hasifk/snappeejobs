<div style="margin-bottom:10px">
    <div class="btn-group">
        <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            CMS <span class="caret"></span>
        </button>
        <ul class="dropdown-menu" role="menu">
            
            <li><a href="{{route('backend.admin.cms_create')}}">Create New</a></li>
            
            <li class="divider"></li>
            
            <li>
                <a href="{{route('backend.admin.cms_lists')}}">All</a>
            </li>
            
            <li>
                <a href="{{route('backend.admin.articles')}}">Articles</a>
            </li>
            
            <li>
                <a href="{{route('backend.admin.blogs')}}">Blogs</a>
            </li>
            
        </ul>
    </div>
</div>