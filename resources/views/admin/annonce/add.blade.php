@extends('layouts.admin')

@section('main')

<form action="{{!empty($annonce)?route('admin.annonce.update', $annonce->id):route('admin.annonce.store')}}" method="post" enctype="multipart/form-data">
    @csrf

        <div class="mb-3">

        <label for="category" class="block mb-2 text-sm font-medium text-gray-900">Selectionnez une option</label>
        <select name="category" class="mb-3 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            
            <option selected>Choisissez une categorie</option>

            @forelse ($categories as $category)
            @if (!empty($actu) && $category->id == $actu->category_id)
                <option value="{{$category->id}}"selected>{{$category->name}}</option>
            @else
                <option value="{{$category->id}}">{{$category->name}}</option>
            @endif
            @empty
            @endforelse

        </select>

        </div >

        <div class="mb-3">

            <label for="nomAnnonce" class="block mb-2 text-sm font-medium text-gray-900">Titre</label>
            <input name="nomAnnonce" type="text" value="{{!empty($annonce)?$annonce->titre:''}}" aria-describedby="helper-text-explanation" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Titre du produit">

            @error('nomAnnonce')
            Veuillez ajouter un titre
            @enderror

        </div>

        <div class="mb-3">

            <label for="description" class="block mb-2 text-sm font-medium text-gray-900">Description</label>
            <textarea name="description" type="text"  rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Description du produit">{{!empty($annonce)?$annonce->description:''}}</textarea>

            @error('description')
            Veuillez ajouter une description
            @enderror


        </div>

        <div class="mb-3">

            <label for="price" class="block mb-2 text-sm font-medium text-gray-900">Prix</label>
            <input name="price" type="number" value="{{!empty($annonce)?$annonce->price:''}}" aria-describedby="helper-text-explanation" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Prix du produit">

            @error('price')
            Veuillez ajouter un prix
            @enderror

        </div>

        <div class="mb-3">

            <label for="image" class="block mb-2 text-sm font-medium text-gray-900 py-1" for="user_avatar">Image</label>

            @isset($annonce)
            <img
                class="h-30 w-20 rounded-full object-cover object-center p-3"
                src="{{Storage::url($annonce->image)}}"
                alt=""
            />
            @endisset

            <input name="image" type="file" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="user_avatar_help" id="user_avatar" type="file">

            @error('price')
            Veuillez ajouter une image
            @enderror

        </div>

        <div class="mb-3">

            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-7 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">{{!empty($actu)?'Modifier':'Ajouter'}}</button>

        </div>

</form>

@endsection