<div class="modal fade" id="deleteModal{{ $consommation->idconsommation }}" tabindex="-1"
     aria-labelledby="deleteModalLabel{{ $consommation->idconsommation }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel{{ $consommation->idconsommation }}">Confirmation de suppression</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Voulez-vous vraiment supprimer ?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Retour</button>
                <form action="/admin/consommation/{{ $consommation->idconsommation }}/delete" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Suppression</button>
                </form>
            </div>
        </div>
    </div>
</div>
