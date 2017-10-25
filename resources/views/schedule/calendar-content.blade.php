@foreach(\App\Tools\Helper::getWeekDays() as $day)
    <li class="events-group">
        <div class="top-info"><span>{{ $day }}</span></div>
        <ul>
            @foreach($data->pluck($day) as $dayevent)
                @if (count($dayevent) > 0)
                    @foreach($dayevent as $event)
                        <li class="single-event" data-slug="{{ $event['slug'] }}" data-start="{{ $event['begin'] }}" data-end="{{ $event['end'] }}" data-content="{{ $event['description'] }}" data-event="event-2">
                            <a href="#0">
                                <em class="event-name">{{ $event['name'] }}</em>
                            </a>
                        </li>
                    @endforeach
                @endif
            @endforeach
        </ul>
    </li>
@endforeach