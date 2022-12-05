<% if $Title && $ShowTitle %><h2 class="element__title">$Title</h2><% end_if %>
<% if $Content %><div class="element__content">$Content</div><% end_if %>

<% if $ElementLinks %>
    <div class="row element__links__list">
        <ul class="list-group">
            <% loop $ElementLinks %>
                <li class="list-group-item">$Me</li>
            <% end_loop %>
        </ul>
    </div>
<% end_if %>
