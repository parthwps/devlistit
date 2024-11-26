@php
    $verify =  App\Models\Vendor::where('id', Auth::guard('vendor')->user()->id)->first();
@endphp
    @if ($verify->phone_verified != 1 && $verify->email_verified_at == NULL)
        <div class="alert alert-warning text-dark">
            {{ __('Your profile is not completed, please complete profile.') }} <a href="{{ route('vendor.edit.profile') }}">
                        <strong style="color: red;">{{ __('Update profile') }}</strong>
                      </a>
          </div>
    @endif