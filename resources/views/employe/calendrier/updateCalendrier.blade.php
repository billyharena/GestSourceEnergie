<div class="modal fade" id="updateModal{{ $calendrier->idcalendrier }}" tabindex="-1"
     aria-labelledby="updateModalLabel{{ $calendrier->idcalendrier }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel{{ $calendrier->idcalendrier }}">Fiche calendrier</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/employe/calendrier/{{ $calendrier->idcalendrier }}/update" method="POST">
                    @csrf
                    @method('PUT')
                     <p>Date : <input class="form-control" type="date" name="datecalendrier" value="{{ $calendrier->datecalendrier }}" placeholder="{{$calendrier->datecalendrier}}"></p>
                    <p>
                        Site :
                        <select name="idsite" class="form-control">
                            @foreach($listeSites as $listeSites)
                                <option value="{{ $listeSites->idsite }}" {{ $listeSites->idsite == $calendrier->idsite ? 'selected' : '' }}>{{ $listeSites->nomsite }}</option>
                            @endforeach
                        </select>
                    </p>
                    <p>
                        Discipline :
                        <select name="iddiscipline" class="form-control">
                            @foreach($listeDiscipline as $listeDiscipline)
                                <option value="{{ $listeDiscipline->iddiscipline }}" {{ $listeDiscipline->iddiscipline == $calendrier->iddiscipline ? 'selected' : '' }}>{{ $listeDiscipline->discipline }}</option>
                            @endforeach
                        </select>
                    </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Retour</button>
                <button type="submit" class="btn btn-danger">Modifier</button>
                </form>
            </div>
        </div>
    </div>
</div>
