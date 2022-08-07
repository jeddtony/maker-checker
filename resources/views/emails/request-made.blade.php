
<div>
<p>

There is a new <strong> {{ $pendingRequest->request_type }} </strong> request from {{ $pendingRequest->admin->first_name }} {{ $pendingRequest->admin->last_name }}

</p>

<p>
    Click here to view the request <a href="{{ url('/v1/pending-request/'.$pendingRequest->uuid) }}">here</a>
</p>
</div>
