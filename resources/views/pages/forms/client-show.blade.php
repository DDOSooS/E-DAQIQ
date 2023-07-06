@extends('layout.master')

@section('content')


    <div class="row">
        <div class="col-md-12 stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title fs-4"> - المدعي</h6>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form method="post" action="{{url('edit-client',$client->id)}}">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label class="form-label"> مرجعكم</label>
                                    <input type="text" class="form-control"  name="vref" placeholder="مثال 1220/2023"  value="{{ (old('vref')!== null)?old('vref'):(isset($oldValues)?$oldValues['vref']:$client->vReference) }}" disabled required>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label class="form-label">مرجعنا</label>
                                    <input type="text" class="form-control"  name="nref" placeholder="مرجعنا"  value="{{ (old('nref')!== null)? old('nref') :(isset($oldValues)?$oldValues['nref'] : $client->nReference )}}" disabled required>
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label class="form-label">Ice</label>
                                    <input type="text" class="form-control" name="ice" placeholder=" Ice"  value="{{ (old('ice')!== null)?old('ice'):(isset($oldValues)?$oldValues['ice']:$client->ice) }}" disabled required>

                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label class="form-label">العنوان</label>
                                    <input type="text" class="form-control" name="adresse"   placeholder=" العنوان"   value="{{ (old('adresse')!== null)?old('adresse'):(isset($oldValues)?$oldValues['adresse']:$client->adresse ) }}" disabled required>
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label class="form-label">الهاتف</label>
                                    <input type="numer" class="form-control" name="telephone"  placeholder="الهاتف"   value="{{ (old('telephone')!== null)?old('telephone'):(isset($oldValues)?$oldValues['telephone']:$client->telephone ) }}" disabled required maxlength="10">
                                </div>
                            </div><!-- Col -->
                        </div><!-- Row -->

                        <select class="form-select form-select-lg mb-2"  required name="typeClient"  id="mySelect" hidden>

                            <option value="{{ $client->type == "ClientsPhysique"? "1":"2" }} "></option>

                        </select>

                        @if($client->type==="ClientsPhysique")
                            <div class="row" id="physique" style="">
                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label class="form-label">Cin</label>
                                        <input type="text" class="form-control" name="cin" placeholder="Cin"   value="{{ (old('cin')!== null)?old('cin'):(isset($oldValues)?$oldValues['cin']:$clientDetails->cin) }}"  disabled >
                                    </div>
                                </div><!-- Col -->
                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label class="form-label"> النسب</label>
                                        <input type="text" class="form-control" name="nom" placeholder="النسب"  value="{{ (old('nom')!== null)?old('nom'):(isset($oldValues)?$oldValues['nom']:$clientDetails->nom) }}" disabled >
                                    </div>
                                </div><!-- Col -->
                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label class="form-label">الاسم</label>
                                        <input type="text" class="form-control" name="prenom" placeholder="الاسم"  value="{{ (old('premom')!== null)?old('premom'):(isset($oldValues)?$oldValues['prenom']:$clientDetails->prenom) }}" disabled >
                                    </div>
                                </div><!-- Col -->
                            </div>
                        @elseif($client->type==="ClientsSociete")
                            <!-- Row -->
                            <div class="row" id="societe" style="">
                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label class="form-label">RC</label>
                                        <input type="text" class="form-control" name="rc" placeholder="RC"  value="{{ (old('rc')!== null)?old('rc'):(isset($oldValues)?$oldValues['rc']:$clientDetails->rc) }}" disabled >
                                    </div>
                                </div><!-- Col -->
                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label class="form-label">اسم الشركة </label>
                                        <input type="text" class="form-control" name="ste" placeholder="اسم الشركة"  value="{{ (old('ste')!== null)?old('ste'):(isset($oldValues)?$oldValues['ste']:$clientDetails->nomSte ) }}" disabled >
                                    </div>
                                </div><!-- Col -->

                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label class="form-label">المسير</label>
                                        <input type="text" class="form-control"  name="gerant" placeholder="المسير"   value="{{ (old('gerant')!== null)?old('gerant'):(isset($oldValues)?$oldValues['gerant']:$clientDetails->gerant) }}"  disabled>
                                    </div>
                                </div><!-- Col -->
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">المقر الرئيسي للشركة </label>
                                        <input type="text" class="form-control"  name="siege" placeholder="المقر الرئيسي للشركة"  value="{{ (old('siege')!== null)?old('siege'):(isset($oldValues)?$oldValues['siege']:$clientDetails->siege ) }}"  disabled >
                                    </div>
                                </div><!-- Col -->
                            </div><!-- Row -->
                        @endif
                        <h6 class="card-title bold fs-4 pt-2"> - المدعى عليه</h6>


                        @foreach($adversaire as $item => $key)



                            <div class="row" >
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">الاسم</label>
                                        <input type="text" class="form-control" name="prenomadv" placeholder="الاسم" value="{{ (old('prenomadv')!== null)?old('prenomadv'):(isset($key)?$key['prenom'] :(isset($oldValues)?$oldValues['prenomadv'] :$key['prenom'])) }}" disabled>
                                    </div>
                                </div><!-- Col -->
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">النسب </label>
                                        <input type="text" class="form-control" name="nomadv" placeholder="النسب" value="{{ (old('nomadv')!== null)?old('nomadv'):(isset($key)?$key['nom'] :(isset($oldValues)?$oldValues['nomadv'] :$key['nom'])) }}" disabled>
                                    </div>
                                </div><!-- Col -->

                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label class="form-label">العنوان 1</label>
                                        <input type="text" class="form-control"  name="adresse1" placeholder="العنوان 1" value="{{ (old('adresse1')!== null)?old('adresse1'):(isset($key)?$key['adresse1'] :(isset($oldValues)?$oldValues['adresse1'] :$key['adresse1'])) }}" disabled>
                                    </div>
                                </div><!-- Col --> <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label class="form-label">العنوان 2</label>
                                        <input type="text" class="form-control"  name="adresse2" placeholder="العنوان 2"   value="{{ (old('adresse2')!== null)?old('adresse2'):(isset($key)?$key['adresse2'] :(isset($oldValues)?$oldValues['adresse2'] : $key['adresse2'])) }}"  disabled>
                                    </div>
                                </div><!-- Col --> <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label class="form-label">العنوان 3</label>
                                        <input type="text" class="form-control"  name="adresse3" placeholder="العنوان 3" value="{{ (old('adresse3')!== null)?old('adresse3'):(isset($key)?$key['adresse3'] :(isset($oldValues)?$oldValues['adresse3'] :  $key['adresse3'])) }}" disabled >
                                    </div>
                                </div><!-- Col -->
                                @endforeach
                            </div><!-- Row -->


                    </form>

                </div>
            </div>
        </div>
    </div>
    <script language="javascript" >
        document.getElementById("mySelect").addEventListener("change", function() {
            var selectedValue = this.value;
            console.log(selectedValue)

            if (selectedValue === "1") {
                document.getElementById("physique").style.display = "";
                document.getElementById("societe").style.display = "none";
            } else if (selectedValue === "2") {
                document.getElementById("physique").style.display = "none";
                document.getElementById("societe").style.display = "";
            }
        });

    </script>

@endsection






