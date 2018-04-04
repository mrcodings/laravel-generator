<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $buku->id !!}</p>
</div>

<!-- Judul Field -->
<div class="form-group">
    {!! Form::label('judul', 'Judul:') !!}
    <p>{!! $buku->judul !!}</p>
</div>

<!-- Deskripsi Field -->
<div class="form-group">
    {!! Form::label('deskripsi', 'Deskripsi:') !!}
    <p>{!! $buku->deskripsi !!}</p>
</div>

<!-- Isi Field -->
<div class="form-group">
    {!! Form::label('isi', 'Isi:') !!}
    <p>{!! $buku->isi !!}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{!! $buku->created_at !!}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{!! $buku->updated_at !!}</p>
</div>

