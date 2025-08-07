<!-- resources/views/employer/seekers-search.blade.php -->

<h2>Search Job Seekers</h2>

<form action="{{ route('seekers.search') }}" method="GET">
    <input type="text" name="name" placeholder="Seeker Name" value="{{ request('name') }}">
    <input type="text" name="skills" placeholder="Seeker Skills" value="{{ request('skills') }}">
    <button type="submit">Search</button>
</form>

@if(isset($seekers))
    <h3>Results:</h3>
    @forelse ($seekers as $seeker)
        <div>
            <strong>{{ $seeker->name }}</strong><br>
            Skills: {{ $seeker->skills }}<br>
            <a href="{{ route('profile.show', $seeker->id) }}">View Profile</a>
        </div>
        <hr>
    @empty
        <p>No seekers found.</p>
    @endforelse
@endif
