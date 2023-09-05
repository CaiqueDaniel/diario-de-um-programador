<div id="form-action-buttons">
    <a href="{{url()->previous()}}" class="btn btn-secondary">{{__('Go Back')}}</a>
    <button type="submit" class="btn btn-primary">
        <div class="spinner-grow spinner-grow-sm d-none" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>

        {{__('Submit')}}
    </button>
</div>
