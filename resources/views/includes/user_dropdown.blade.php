{{-- <option selected disabled>--{{ __('Select One') }}--</option> --}}
@foreach ($show_users as $user)
    <option value="{{ $user->id }}">{{ ucwords($user->name) }}</option>
@endforeach
