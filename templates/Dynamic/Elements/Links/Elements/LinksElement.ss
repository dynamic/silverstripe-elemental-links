<% if $Title && $ShowTitle %><h2 class="element__title">$Title</h2><% end_if %>
<% if $Content %><div class="element__content">$Content</div><% end_if %>

<% if $ElementLinks %>
    <div class="row element__links__list">
        <div class="col-md-12">
            <ul class="list-group">
                <% loop $ElementLinks %>
                    <a href="$LinkObject.URL" class="list-group-item list-group-item-action" title="$Title"<% if $LinkObject.OpenInNew %> target="_blank" rel="noopener noreferrer"<% end_if %>>
                        <div class="d-flex w-100 justify-content-between">
                            <h4 class="mb-1">
                                <i class="bi bi-link-45deg"></i>
                                $Title
                            </h4>
                            <small>updated $LastEdited.Ago</small>
                        </div>
                        $Content
                        <% if $LinkObject.URL %><p>$LinkObject.URL</p><% end_if %>
                    </a>
                <% end_loop %>
            </ul>
        </div>
    </div>
<% end_if %>
