<% if $Title && $ShowTitle %><h2 class="element__title">$Title</h2><% end_if %>
<% if $Content %><div class="element__content">$Content</div><% end_if %>

<% if $ElementLinks %>
    <div class="row element__links__list">
        <div class="col-md-12">
            <ul class="list-group">
                <% loop $ElementLinks.Sort('SortOrder') %>
                    <% if $Link.exists %>
                        <a href="$Link.URL" class="list-group-item list-group-item-action" title="$Title"<% if $Link.OpenInNew %> target="_blank" rel="noopener noreferrer"<% end_if %>>
                            <div class="d-flex w-100 justify-content-between">
                                <% if $ShowTitle %><h4 class="mb-1">$Title</h4><% end_if %>
                            </div>
                            $Content
                            <div class="d-flex gap-3">
                                <% with $Link %>
                                    <i class="bi bi-link-45deg"></i>
                                    <div class="d-flex gap-2 w-100">
                                        <small>
                                            <% if $Title %>$Title<% else %>{$URL}<% end_if %>
                                        </small>
                                    </div>
                                <% end_with %>
                            </div>
                        </a>
                    <% end_if %>
                <% end_loop %>
            </ul>
        </div>
    </div>
<% end_if %>
