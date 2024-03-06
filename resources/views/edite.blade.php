@extends('layaout.master')

@section('main')

<div id="addEventSection" style="height: 100vh" class="container  content-section">
    <div class="content">
        <h2>Modifer Evenement</h2>

        <form action={{ route('updateEvenement', ['id' => $evenement->id]) }} method="post">
            @csrf
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Titer</label>
                <input type="text" class="form-control" name="titre" id="exampleFormControlInput1"
                    placeholder="titre" value=" {{$evenement->titre}} ">
                @error('titre')
                    {{ $message }}
                @enderror
            </div>
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Description</label>
                <textarea class="form-control" name="description" id="exampleFormControlTextarea1" rows="3">{{$evenement->description}}</textarea>
            </div>
            
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>
@endsection
