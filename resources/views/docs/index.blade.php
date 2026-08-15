@extends('layouts.app')

@section('title', 'Documentación API - La Buena Mesa')

@section('content')

<div class="api-docs">

    {{-- ============================================
         ENCABEZADO DE DOCUMENTACIÓN
    ============================================= --}}

    <div class="api-docs__intro">

        <div>
            <span class="api-docs__eyebrow">
                DOCUMENTACIÓN REST API
            </span>

            <h2>
                La Buena Mesa API
            </h2>

            <p>
                Documentación interactiva para consultar y administrar
                los elementos del menú mediante la API RESTful.
            </p>
        </div>

        <div class="api-docs__base-url">

            <span>
                BASE URL
            </span>

            <code>
                {{ url('/docs') }}
            </code>

        </div>

    </div>


    {{-- ============================================
         NAVEGACIÓN DE ENDPOINTS
    ============================================= --}}

    <div class="api-docs__navigation">

        <a href="#ep-get-all">
            <span class="api-nav-method api-nav-method--get">
                GET
            </span>
            Listar menú
        </a>

        <a href="#ep-get-cat">
            <span class="api-nav-method api-nav-method--get">
                GET
            </span>
            Por categoría
        </a>

        <a href="#ep-post">
            <span class="api-nav-method api-nav-method--post">
                POST
            </span>
            Crear
        </a>

        <a href="#ep-get-id">
            <span class="api-nav-method api-nav-method--get">
                GET
            </span>
            Obtener por ID
        </a>

        <a href="#ep-put">
            <span class="api-nav-method api-nav-method--put">
                PUT
            </span>
            Actualizar
        </a>

        <a href="#ep-delete">
            <span class="api-nav-method api-nav-method--delete">
                DELETE
            </span>
            Eliminar
        </a>

    </div>


    {{-- ============================================================
         1. GET /menu-items
    ============================================================= --}}

    <section
        id="ep-get-all"
        class="api-endpoint api-endpoint--get"
    >

        {{-- HEADER --}}

        <div class="api-endpoint__header">

            <div class="api-method api-method--get">
                GET
            </div>

            <code class="api-endpoint__url">
                /api/menu-items
            </code>

            <span class="api-endpoint__title">
                Listar elementos del menú
            </span>

        </div>


        {{-- CONTENT --}}

        <div class="api-endpoint__content">

            {{-- IZQUIERDA --}}

            <div class="api-endpoint__info">

                <span class="api-section-label">
                    DESCRIPCIÓN
                </span>

                <h3>
                    Obtener elementos del menú
                </h3>

                <p>
                    Devuelve los elementos registrados en el menú.
                    Permite utilizar filtros opcionales para consultar
                    por categoría y disponibilidad.
                </p>


                <span class="api-section-label">
                    PARÁMETROS
                </span>


                <div class="api-parameter">

                    <div>

                        <code>category</code>

                        <span class="api-parameter__type">
                            string
                        </span>

                        <span class="api-optional">
                            opcional
                        </span>

                    </div>

                    <p>
                        Filtra los elementos por categoría.
                    </p>

                </div>


                <div class="api-parameter">

                    <div>

                        <code>available</code>

                        <span class="api-parameter__type">
                            boolean
                        </span>

                        <span class="api-optional">
                            opcional
                        </span>

                    </div>

                    <p>
                        Filtra los elementos según su disponibilidad.
                    </p>

                </div>


                <div class="api-example-url">

                    <span>
                        EJEMPLO
                    </span>

                    <code>
                        GET /api/menu-items?category=postre&available=1
                    </code>

                </div>

            </div>


            {{-- DERECHA --}}

            <div class="api-endpoint__try">

                <div class="api-try-header">

                    <div>

                        <span class="api-section-label">
                            PROBAR ENDPOINT
                        </span>

                        <p>
                            Ejecuta una solicitud contra la API.
                        </p>

                    </div>

                </div>


                <div class="api-field">

                    <label for="get-all-cat">
                        category
                    </label>

                    <input
                        type="text"
                        id="get-all-cat"
                        placeholder="ej: postre"
                    >

                </div>


                <div class="api-field">

                    <label for="get-all-avail">
                        available
                    </label>

                    <select id="get-all-avail">

                        <option value="">
                            Todos
                        </option>

                        <option value="1">
                            Disponible
                        </option>

                        <option value="0">
                            No disponible
                        </option>

                    </select>

                </div>


                <button
                    type="button"
                    class="api-button api-button--get"
                    onclick="executeRequest(
                        'GET',
                        '/menu-items',
                        null,
                        'response-get-all'
                    )"
                >
                    ▶ Ejecutar
                </button>


                <div class="api-response">

                    <div class="api-response__header">

                        <span>
                            RESPUESTA
                        </span>

                        <span class="api-status">
                            JSON
                        </span>

                    </div>

                    <pre id="response-get-all">Haz clic en "Ejecutar" para probar...</pre>

                </div>

            </div>

        </div>

    </section>


    {{-- ============================================================
         2. GET /menu-items/category/{category}
    ============================================================= --}}

    <section
        id="ep-get-cat"
        class="api-endpoint api-endpoint--get"
    >

        <div class="api-endpoint__header">

            <div class="api-method api-method--get">
                GET
            </div>

            <code class="api-endpoint__url">
                /api/menu-items/category/{category}
            </code>

            <span class="api-endpoint__title">
                Filtrar por categoría
            </span>

        </div>


        <div class="api-endpoint__content">

            {{-- IZQUIERDA --}}

            <div class="api-endpoint__info">

                <span class="api-section-label">
                    DESCRIPCIÓN
                </span>

                <h3>
                    Obtener elementos por categoría
                </h3>

                <p>
                    Devuelve únicamente los elementos pertenecientes
                    a una categoría específica del menú.
                </p>


                <span class="api-section-label">
                    PARÁMETROS
                </span>


                <div class="api-parameter">

                    <div>

                        <code>category</code>

                        <span class="api-parameter__type">
                            string
                        </span>

                        <span class="api-required">
                            requerido
                        </span>

                    </div>

                    <p>
                        Nombre de la categoría que se desea consultar.
                    </p>

                </div>


                <div class="api-example-url">

                    <span>
                        EJEMPLO
                    </span>

                    <code>
                        GET /api/menu-items/category/postre
                    </code>

                </div>

            </div>


            {{-- DERECHA --}}

            <div class="api-endpoint__try">

                <div class="api-try-header">

                    <div>

                        <span class="api-section-label">
                            PROBAR ENDPOINT
                        </span>

                        <p>
                            Introduce una categoría para realizar la consulta.
                        </p>

                    </div>

                </div>


                <div class="api-field">

                    <label for="get-cat-val">
                        category
                    </label>

                    <input
                        type="text"
                        id="get-cat-val"
                        value="postre"
                        placeholder="ej: postre"
                    >

                </div>


                <button
                    type="button"
                    class="api-button api-button--get"
                    onclick="executeCategoryRequest()"
                >
                    ▶ Ejecutar
                </button>


                <div class="api-response">

                    <div class="api-response__header">

                        <span>
                            RESPUESTA
                        </span>

                        <span class="api-status">
                            JSON
                        </span>

                    </div>

                    <pre id="response-get-cat">Haz clic en "Ejecutar" para probar...</pre>

                </div>

            </div>

        </div>

    </section>


    {{-- ============================================================
         3. POST /menu-items
    ============================================================= --}}

    <section
        id="ep-post"
        class="api-endpoint api-endpoint--post"
    >

        <div class="api-endpoint__header">

            <div class="api-method api-method--post">
                POST
            </div>

            <code class="api-endpoint__url">
                /api/menu-items
            </code>

            <span class="api-endpoint__title">
                Crear elemento
            </span>

        </div>


        <div class="api-endpoint__content">

            {{-- IZQUIERDA --}}

            <div class="api-endpoint__info">

                <span class="api-section-label">
                    DESCRIPCIÓN
                </span>

                <h3>
                    Crear un nuevo platillo
                </h3>

                <p>
                    Crea un nuevo elemento dentro del menú utilizando
                    un objeto JSON enviado en el cuerpo de la solicitud.
                </p>


                <span class="api-section-label">
                    REQUEST BODY
                </span>


                <div class="api-parameter">

                    <div>

                        <code>name</code>

                        <span class="api-parameter__type">
                            string
                        </span>

                        <span class="api-required">
                            requerido
                        </span>

                    </div>

                    <p>
                        Nombre del platillo.
                    </p>

                </div>


                <div class="api-parameter">

                    <div>

                        <code>description</code>

                        <span class="api-parameter__type">
                            string
                        </span>

                    </div>

                    <p>
                        Descripción del platillo.
                    </p>

                </div>


                <div class="api-parameter">

                    <div>

                        <code>price</code>

                        <span class="api-parameter__type">
                            number
                        </span>

                        <span class="api-required">
                            requerido
                        </span>

                    </div>

                    <p>
                        Precio del producto.
                    </p>

                </div>


                <div class="api-parameter">

                    <div>

                        <code>category</code>

                        <span class="api-parameter__type">
                            string
                        </span>

                        <span class="api-required">
                            requerido
                        </span>

                    </div>

                    <p>
                        Categoría a la que pertenece.
                    </p>

                </div>


                <div class="api-parameter">

                    <div>

                        <code>available</code>

                        <span class="api-parameter__type">
                            boolean
                        </span>

                    </div>

                    <p>
                        Indica si el platillo está disponible.
                    </p>

                </div>

            </div>


            {{-- DERECHA --}}

            <div class="api-endpoint__try">

                <div class="api-try-header">

                    <div>

                        <span class="api-section-label">
                            PROBAR ENDPOINT
                        </span>

                        <p>
                            Modifica el JSON y ejecuta la solicitud.
                        </p>

                    </div>

                </div>


                <div class="api-field">

                    <label for="post-body">
                        JSON Body
                    </label>

                    <textarea
                        id="post-body"
                        class="api-json-editor"
                        rows="10"
                    >{
    "name": "Ensalada César con Pollo",
    "description": "Lechuga romana crujiente, crutones, aderezo César y pechuga a la parrilla.",
    "price": 9.50,
    "category": "plato_fuerte",
    "available": true
}</textarea>

                </div>


                <button
                    type="button"
                    class="api-button api-button--post"
                    onclick="executePostRequest()"
                >
                    ▶ Ejecutar
                </button>


                <div class="api-response">

                    <div class="api-response__header">

                        <span>
                            RESPUESTA
                        </span>

                        <span class="api-status">
                            JSON
                        </span>

                    </div>

                    <pre id="response-post">Haz clic en "Ejecutar" para probar...</pre>

                </div>

            </div>

        </div>

    </section>


    {{-- ============================================================
         4. GET /menu-items/{id}
    ============================================================= --}}

    <section
        id="ep-get-id"
        class="api-endpoint api-endpoint--get"
    >

        <div class="api-endpoint__header">

            <div class="api-method api-method--get">
                GET
            </div>

            <code class="api-endpoint__url">
                /api/menu-items/{id}
            </code>

            <span class="api-endpoint__title">
                Obtener por ID
            </span>

        </div>


        <div class="api-endpoint__content">

            {{-- IZQUIERDA --}}

            <div class="api-endpoint__info">

                <span class="api-section-label">
                    DESCRIPCIÓN
                </span>

                <h3>
                    Obtener un elemento específico
                </h3>

                <p>
                    Permite consultar la información completa de un
                    elemento del menú utilizando su identificador.
                </p>


                <span class="api-section-label">
                    PARÁMETROS
                </span>


                <div class="api-parameter">

                    <div>

                        <code>id</code>

                        <span class="api-parameter__type">
                            integer
                        </span>

                        <span class="api-required">
                            requerido
                        </span>

                    </div>

                    <p>
                        Identificador único del elemento.
                    </p>

                </div>


                <div class="api-example-url">

                    <span>
                        EJEMPLO
                    </span>

                    <code>
                        GET /api/menu-items/1
                    </code>

                </div>

            </div>


            {{-- DERECHA --}}

            <div class="api-endpoint__try">

                <div class="api-try-header">

                    <div>

                        <span class="api-section-label">
                            PROBAR ENDPOINT
                        </span>

                        <p>
                            Introduce el ID que deseas consultar.
                        </p>

                    </div>

                </div>


                <div class="api-field">

                    <label for="get-id-val">
                        ID del elemento
                    </label>

                    <input
                        type="number"
                        id="get-id-val"
                        value="1"
                        min="1"
                    >

                </div>


                <button
                    type="button"
                    class="api-button api-button--get"
                    onclick="executeGetIdRequest()"
                >
                    ▶ Ejecutar
                </button>


                <div class="api-response">

                    <div class="api-response__header">

                        <span>
                            RESPUESTA
                        </span>

                        <span class="api-status">
                            JSON
                        </span>

                    </div>

                    <pre id="response-get-id">Haz clic en "Ejecutar" para probar...</pre>

                </div>

            </div>

        </div>

    </section>


    {{-- ============================================================
         5. PUT /menu-items/{id}
    ============================================================= --}}

    <section
        id="ep-put"
        class="api-endpoint api-endpoint--put"
    >

        <div class="api-endpoint__header">

            <div class="api-method api-method--put">
                PUT
            </div>

            <code class="api-endpoint__url">
                /api/menu-items/{id}
            </code>

            <span class="api-endpoint__title">
                Actualizar elemento
            </span>

        </div>


        <div class="api-endpoint__content">

            {{-- IZQUIERDA --}}

            <div class="api-endpoint__info">

                <span class="api-section-label">
                    DESCRIPCIÓN
                </span>

                <h3>
                    Actualizar un elemento
                </h3>

                <p>
                    Actualiza uno o varios datos de un elemento existente
                    utilizando su identificador.
                </p>


                <span class="api-section-label">
                    PARÁMETROS
                </span>


                <div class="api-parameter">

                    <div>

                        <code>id</code>

                        <span class="api-parameter__type">
                            integer
                        </span>

                        <span class="api-required">
                            requerido
                        </span>

                    </div>

                    <p>
                        Identificador del elemento que será actualizado.
                    </p>

                </div>


                <span class="api-section-label api-section-label--body">
                    REQUEST BODY
                </span>


                <div class="api-code-example">

<pre>{
    "price": 10.99,
    "available": false
}</pre>

                </div>

            </div>


            {{-- DERECHA --}}

            <div class="api-endpoint__try">

                <div class="api-try-header">

                    <div>

                        <span class="api-section-label">
                            PROBAR ENDPOINT
                        </span>

                        <p>
                            Introduce el ID y modifica el JSON.
                        </p>

                    </div>

                </div>


                <div class="api-field">

                    <label for="put-id-val">
                        ID del elemento
                    </label>

                    <input
                        type="number"
                        id="put-id-val"
                        value="1"
                        min="1"
                    >

                </div>


                <div class="api-field">

                    <label for="put-body">
                        JSON Body
                    </label>

                    <textarea
                        id="put-body"
                        class="api-json-editor"
                        rows="8"
                    >{
    "price": 10.99,
    "available": false
}</textarea>

                </div>


                <button
                    type="button"
                    class="api-button api-button--put"
                    onclick="executePutRequest()"
                >
                    ▶ Ejecutar
                </button>


                <div class="api-response">

                    <div class="api-response__header">

                        <span>
                            RESPUESTA
                        </span>

                        <span class="api-status">
                            JSON
                        </span>

                    </div>

                    <pre id="response-put">Haz clic en "Ejecutar" para probar...</pre>

                </div>

            </div>

        </div>

    </section>


    {{-- ============================================================
         6. DELETE /menu-items/{id}
    ============================================================= --}}

    <section
        id="ep-delete"
        class="api-endpoint api-endpoint--delete"
    >

        <div class="api-endpoint__header">

            <div class="api-method api-method--delete">
                DELETE
            </div>

            <code class="api-endpoint__url">
                /api/menu-items/{id}
            </code>

            <span class="api-endpoint__title">
                Eliminar elemento
            </span>

        </div>


        <div class="api-endpoint__content">

            {{-- IZQUIERDA --}}

            <div class="api-endpoint__info">

                <span class="api-section-label">
                    DESCRIPCIÓN
                </span>

                <h3>
                    Eliminar un platillo
                </h3>

                <p>
                    Elimina un elemento existente del menú utilizando
                    su identificador único.
                </p>


                <span class="api-section-label">
                    PARÁMETROS
                </span>


                <div class="api-parameter">

                    <div>

                        <code>id</code>

                        <span class="api-parameter__type">
                            integer
                        </span>

                        <span class="api-required">
                            requerido
                        </span>

                    </div>

                    <p>
                        Identificador del elemento que se desea eliminar.
                    </p>

                </div>


                <div class="api-warning">

                    <strong>
                        ⚠ Atención
                    </strong>

                    <p>
                        Esta operación elimina el elemento seleccionado.
                        Verifica el ID antes de ejecutar la solicitud.
                    </p>

                </div>

            </div>


            {{-- DERECHA --}}

            <div class="api-endpoint__try">

                <div class="api-try-header">

                    <div>

                        <span class="api-section-label">
                            PROBAR ENDPOINT
                        </span>

                        <p>
                            Introduce el ID que deseas eliminar.
                        </p>

                    </div>

                </div>


                <div class="api-field">

                    <label for="delete-id-val">
                        ID del elemento
                    </label>

                    <input
                        type="number"
                        id="delete-id-val"
                        value="1"
                        min="1"
                    >

                </div>


                <button
                    type="button"
                    class="api-button api-button--delete"
                    onclick="executeDeleteRequest()"
                >
                    🗑 Eliminar
                </button>


                <div class="api-response">

                    <div class="api-response__header">

                        <span>
                            RESPUESTA
                        </span>

                        <span class="api-status">
                            JSON
                        </span>

                    </div>

                    <pre id="response-delete">Haz clic en "Eliminar" para probar...</pre>

                </div>

            </div>

        </div>

    </section>

</div>

@endsection


{{-- ============================================================
     JAVASCRIPT
============================================================= --}}

@push('scripts')

<script>

const baseUrl = @json(url('/api'));


/*
|--------------------------------------------------------------------------
| Mostrar respuesta
|--------------------------------------------------------------------------
*/

function showResponse(responseId, data, status = null)
{
    const element = document.getElementById(responseId);

    if (!element) {
        return;
    }

    let output = '';

    if (status !== null) {
        output += `HTTP ${status}\n\n`;
    }

    output += JSON.stringify(data, null, 2);

    element.textContent = output;
}


/*
|--------------------------------------------------------------------------
| Obtener respuesta JSON
|--------------------------------------------------------------------------
*/

async function parseResponse(response)
{
    const text = await response.text();

    try {

        return JSON.parse(text);

    } catch (error) {

        return {
            message: text || 'La API no devolvió contenido.'
        };

    }
}


/*
|--------------------------------------------------------------------------
| GET /menu-items
|--------------------------------------------------------------------------
*/

async function executeRequest(
    method,
    endpoint,
    bodyData,
    responseId
) {

    let url = baseUrl + endpoint;


    if (endpoint === '/menu-items') {

        const category =
            document
                .getElementById('get-all-cat')
                .value
                .trim();

        const available =
            document
                .getElementById('get-all-avail')
                .value;


        const params = new URLSearchParams();


        if (category) {

            params.append(
                'category',
                category
            );

        }


        if (available !== '') {

            params.append(
                'available',
                available
            );

        }


        if (params.toString()) {

            url += '?' + params.toString();

        }

    }


    const responseElement =
        document.getElementById(responseId);


    responseElement.textContent =
        'Procesando solicitud...';


    try {

        const response =
            await fetch(url, {

                method: method,

                headers: {
                    'Accept': 'application/json'
                }

            });


        const data =
            await parseResponse(response);


        showResponse(
            responseId,
            data,
            response.status
        );


    } catch (error) {

        responseElement.textContent =
            'Error de conexión: ' +
            error.message;

    }

}


/*
|--------------------------------------------------------------------------
| GET /menu-items/category/{category}
|--------------------------------------------------------------------------
*/

async function executeCategoryRequest()
{

    const category =
        document
            .getElementById('get-cat-val')
            .value
            .trim();


    const responseElement =
        document.getElementById(
            'response-get-cat'
        );


    if (!category) {

        responseElement.textContent =
            'Debes introducir una categoría.';

        return;

    }


    const url =
        `${baseUrl}/menu-items/category/${encodeURIComponent(category)}`;


    responseElement.textContent =
        'Procesando solicitud...';


    try {

        const response =
            await fetch(url, {

                method: 'GET',

                headers: {
                    'Accept': 'application/json'
                }

            });


        const data =
            await parseResponse(response);


        showResponse(
            'response-get-cat',
            data,
            response.status
        );


    } catch (error) {

        responseElement.textContent =
            'Error de conexión: ' +
            error.message;

    }

}


/*
|--------------------------------------------------------------------------
| POST /menu-items
|--------------------------------------------------------------------------
*/

async function executePostRequest()
{

    const url =
        `${baseUrl}/menu-items`;


    const body =
        document
            .getElementById('post-body')
            .value;


    const responseElement =
        document.getElementById(
            'response-post'
        );


    responseElement.textContent =
        'Procesando solicitud...';


    let jsonBody;


    try {

        jsonBody =
            JSON.parse(body);

    } catch (error) {

        responseElement.textContent =
            'Error: el JSON ingresado no es válido.\n\n' +
            error.message;

        return;

    }


    try {

        const response =
            await fetch(url, {

                method: 'POST',

                headers: {

                    'Content-Type':
                        'application/json',

                    'Accept':
                        'application/json'

                },

                body:
                    JSON.stringify(jsonBody)

            });


        const data =
            await parseResponse(response);


        showResponse(
            'response-post',
            data,
            response.status
        );


    } catch (error) {

        responseElement.textContent =
            'Error de conexión: ' +
            error.message;

    }

}


/*
|--------------------------------------------------------------------------
| GET /menu-items/{id}
|--------------------------------------------------------------------------
*/

async function executeGetIdRequest()
{

    const id =
        document
            .getElementById('get-id-val')
            .value;


    const responseElement =
        document.getElementById(
            'response-get-id'
        );


    if (!id) {

        responseElement.textContent =
            'Debes introducir un ID.';

        return;

    }


    const url =
        `${baseUrl}/menu-items/${encodeURIComponent(id)}`;


    responseElement.textContent =
        'Procesando solicitud...';


    try {

        const response =
            await fetch(url, {

                method: 'GET',

                headers: {
                    'Accept': 'application/json'
                }

            });


        const data =
            await parseResponse(response);


        showResponse(
            'response-get-id',
            data,
            response.status
        );


    } catch (error) {

        responseElement.textContent =
            'Error de conexión: ' +
            error.message;

    }

}


/*
|--------------------------------------------------------------------------
| PUT /menu-items/{id}
|--------------------------------------------------------------------------
*/

async function executePutRequest()
{

    const id =
        document
            .getElementById('put-id-val')
            .value;


    const body =
        document
            .getElementById('put-body')
            .value;


    const responseElement =
        document.getElementById(
            'response-put'
        );


    if (!id) {

        responseElement.textContent =
            'Debes introducir un ID.';

        return;

    }


    let jsonBody;


    try {

        jsonBody =
            JSON.parse(body);

    } catch (error) {

        responseElement.textContent =
            'Error: el JSON ingresado no es válido.\n\n' +
            error.message;

        return;

    }


    const url =
        `${baseUrl}/menu-items/${encodeURIComponent(id)}`;


    responseElement.textContent =
        'Procesando solicitud...';


    try {

        const response =
            await fetch(url, {

                method: 'PUT',

                headers: {

                    'Content-Type':
                        'application/json',

                    'Accept':
                        'application/json'

                },

                body:
                    JSON.stringify(jsonBody)

            });


        const data =
            await parseResponse(response);


        showResponse(
            'response-put',
            data,
            response.status
        );


    } catch (error) {

        responseElement.textContent =
            'Error de conexión: ' +
            error.message;

    }

}


/*
|--------------------------------------------------------------------------
| DELETE /menu-items/{id}
|--------------------------------------------------------------------------
*/

async function executeDeleteRequest()
{

    const id =
        document
            .getElementById('delete-id-val')
            .value;


    const responseElement =
        document.getElementById(
            'response-delete'
        );


    if (!id) {

        responseElement.textContent =
            'Debes introducir un ID.';

        return;

    }


    const confirmed =
        confirm(
            `¿Estás seguro de eliminar el elemento #${id}?`
        );


    if (!confirmed) {

        return;

    }


    const url =
        `${baseUrl}/menu-items/${encodeURIComponent(id)}`;


    responseElement.textContent =
        'Procesando solicitud...';


    try {

        const response =
            await fetch(url, {

                method: 'DELETE',

                headers: {

                    'Accept':
                        'application/json'

                }

            });


        const data =
            await parseResponse(response);


        showResponse(
            'response-delete',
            data,
            response.status
        );


    } catch (error) {

        responseElement.textContent =
            'Error de conexión: ' +
            error.message;

    }

}

</script>

@endpush