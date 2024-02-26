<div class="modal fade" id="updateModal{{ $jirama->idjirama }}" tabindex="-1"
     aria-labelledby="updateModalLabel{{ $jirama->idjirama }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel{{ $jirama->idjirama }}">Fiche jirama</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/admin/jirama/{{ $jirama->idjirama }}/update" method="POST">
                    @csrf
                    @method('PUT')
                    <p>Capacité max : <input class="form-control" type="number" name="capacitemax" value="{{ $jirama->capacitemax }}" placeholder="{{$jirama->capacitemax}}"></p>
                    <p>Tarif : <input class="form-control" type="number" name="tarifjirama" value="{{ $jirama->tarifjirama }}" placeholder="{{$jirama->tarifjirama}}"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Retour</button>
                <button type="submit" class="btn btn-danger">Modifier</button>
                </form>
            </div>
        </div>
    </div>
</div>
