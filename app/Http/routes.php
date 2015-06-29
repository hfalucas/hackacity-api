<?php

post('login', 'AuthController@login');

get('locals/{id}/users', 'EventsController@show');
post('events/{id}/join', 'EventsController@join');
post('events', 'EventsController@store');
