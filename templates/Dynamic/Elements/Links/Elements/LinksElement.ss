<% if $Title && $ShowTitle %><h2 class="element__title">$Title</h2><% end_if %>

<% if $ElementLinks %>
    <% loop $ElementLinks %>
        $Me
    <% end_loop %>
<% end_if %>
