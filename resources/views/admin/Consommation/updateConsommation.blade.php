<div class="modal fade" id="updateModal{{ $consommation->idconsommation }}" tabindex="-1"
     aria-labelledby="updateModalLabel{{ $consommation->idconsommation }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel{{ $consommation->idconsommation }}">Fiche consommation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/admin/consommation/{{ $consommation->idconsommation }}/update" method="POST">
                    @csrf
                    @method('PUT')
                    <p>Nombre d'étudiant : <input class="form-control" type="number" step="any" name="nbetudiant" value="{{ $consommation->nbetudiant }}" placeholder="{{$consommation->nbetudiant}}"></p>
                    <p>Puissance laptop : <input class="form-control" type="number" step="any" name="puissancelaptop" value="{{ $consommation->puissancelaptop }}" placeholder="{{$consommation->puissancelaptop}}"></p>
                    <p>Consommation fixe : <input class="form-control" type="number" step="any" name="consofixe" value="{{ $consommation->consofixe }}" placeholder="{{$consommation->consofixe}}"></p>
                    <p>Pourcentage restant : <input class="form-control" type="number" step="any" name="pourcentage" value="{{ $consommation->pourcentage }}" placeholder="{{$consommation->pourcentage}}"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Retour</button>
                <button type="submit" class="btn btn-danger">Modifier</button>
                </form>
            </div>
        </div>
    </div>
</div>
