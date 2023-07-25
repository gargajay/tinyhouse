
<ul>
<li><a href="{{ url('my-home') }}" class="{{ request()->is('my-home') ? 'active' : '' }}">My Tiny Homes</a></li>
    <li><a href="{{ url('account-setting') }}" class="{{ request()->is('account-setting') ? 'active' : '' }}">Account Settings</a></li>
    <!-- <li><a href="javascript:void(0);">Blocked Users</a></li> -->
</ul>