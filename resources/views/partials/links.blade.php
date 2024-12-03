<div class="is-flex is-align-items-center" style="height: 100%;">
    <h2 class="title is-4 mr-4 mb-0">
        Your Links
    </h2>
    <form action="{{ route('links.generate') }}" method="POST">
        @csrf
        <button type="submit" class="button is-primary">Generate New Link</button>
    </form>
</div>

<table class="table is-striped is-fullwidth is-size-7">
    <thead>
        <tr>
            <th>Link</th>
            <th>Valid Until</th>
            <th>Time Left</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($links as $link)
        <tr>
            <td>
                <a href="{{ route('user.login', ['uuid' => $link->code]) }}">
                    {{ route('user.login', ['uuid' => $link->code]) }}
                </a>
            </td>
            <td>{{ $link->valid_until->toDayDateTimeString() }}</td>
            <td>{{ $link->valid_until->diffForHumans() }}</td>
            <td>
                <span class="tag {{ $link->is_deactivated ? 'is-danger' : 'is-success' }}">
                    {{ $link->is_deactivated ? 'Inactive' : 'Active' }}
                </span>
            </td>
            <td>
                @if (!$link->is_deactivated)
                <form action="{{ route('links.deactivate') }}" method="POST" class="is-inline">
                    @csrf
                    <input type="hidden" name="code" value="{{ $link->code }}">
                    <button type="submit" class="button is-danger is-small">Deactivate</button>
                </form>
                @else
                <span class="has-text-grey">---</span>
                @endif
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="5" class="has-text-centered">No links available.</td>
        </tr>
        @endforelse
    </tbody>
</table>