<table class="table table-responsive" id="bukus-table">
    <thead>
        <th>Judul</th>
        <th>Deskripsi</th>
        <th>Isi</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($bukus as $buku)
        <tr>
            <td>{!! $buku->judul !!}</td>
            <td>{!! $buku->deskripsi !!}</td>
            <td>{!! $buku->isi !!}</td>
            <td>
                {!! Form::open(['route' => ['bukus.destroy', $buku->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('bukus.show', [$buku->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('bukus.edit', [$buku->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>