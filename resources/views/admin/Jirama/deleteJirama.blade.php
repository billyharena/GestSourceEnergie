<div class="modal fade" id="deleteModal{{ $jirama->idjirama }}" tabindex="-1"
     aria-labelledby="deleteModalLabel{{ $jirama->idjirama }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel{{ $jirama->idjirama }}">Confirmation de suppression</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Voulez-vous vraiment supprimer ?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Retour</button>
                <form action="/admin/jirama/{{ $jirama->idjirama }}/delete" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Suppression</button>
                </form>
            </div>
        </div>
    </div>
</div>
