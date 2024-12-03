<div class="is-flex is-align-items-center" style="height: 100%;">
    <h2 class="title is-4 mr-4 mb-0">
        Game History
    </h2>
    <form action="{{ route('games.play') }}" method="POST">
        @csrf
        <button type="submit" class="button is-success">
            <span class="icon" style="color: green">
                <i class="fas fa-clover"></i>
            </span>
            <span>I'm Feeling Lucky</span>
        </button>
    </form>
</div>


@if (session('result'))
<div class="box">
    <h2 class="title is-5">Game Result</h2>
    <p><strong>Random Number:</strong> {{ session('result.randomNumber') }}</p>
    <p><strong>Result:</strong> <span class="tag {{ session('result.isWon') ? 'is-success' : 'is-danger' }}">
            {{ session('result.isWon') ? 'Win' : 'Lose' }}</span>
    </p>
    <p><strong>Prize:</strong> {{ session('result.prize') }}</p>
</div>
@endif

<table class="table is-striped is-fullwidth is-size-7">
    <thead>
        <tr>
            <th>Random Number</th>
            <th>Result</th>
            <th>Prize</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($games as $game)
        <tr>
            <td>{{ $game->random }}</td>
            <td>
                <span class="tag {{ $game->is_won ? 'is-success' : 'is-danger' }}">
                    {{ $game->is_won ? 'Win' : 'Lose' }}
                </span>
            </td>
            <td>{{ $game->prize }}</td>
            <td>{{ $game->created_at->toDayDateTimeString() }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="4" class="has-text-centered">No game history available.</td>
        </tr>
        @endforelse
    </tbody>
</table>