@if(Session('message'))
    <div class="alert alert-success">{{ Session('message') }}</div>
@endif
@if(Session('error'))
    <div class="alert alert-danger">{{ Session('error') }}</div>
@endif
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif