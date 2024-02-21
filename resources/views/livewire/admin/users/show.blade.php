<div>
    @if($user)

        {{ $user->name }}
        {{ $user->email }}
        {{ $user->created_at->format('d/m/Y H:i') }}
        {{ $user->updated_at->format('d/m/Y H:i') }}
        {{ $user->deleted_at->format('d/m/Y H:i') }}
        {{ $user->deletedBy->name }}

    @endif
</div>
