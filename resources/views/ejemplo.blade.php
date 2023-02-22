<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Gestión de restaurante - QR de mesa</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    </head>
    <body>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

        <div style="display: flex; flex-direction: column">
          <h3 style="margin: auto">{{ $table->name }} </h3>
          <img style="margin: auto" src="data:image/png;base64, {!! base64_encode($qr) !!}" alt="" srcset="">
        </div>

        

        {{-- <div style="margin-top: 20px">
          <table class="table table-striped text-center" >
            <thead>
              <tr>
                <th 
                  scope="col" 
                  style="background-color: #c7c7c7"
                >
                  Cantidad
                </th>                       
                
                <th scope="col" style="background-color: #c7c7c7
                ">
                  Descripción
                </th>
                
                <th scope="col" style="background-color: #c7c7c7
                ">
                  Precio
                </th>
                
                <th scope="col" style="background-color: #c7c7c7
                ">
                  Subtotal
                </th>  
              </tr>
            </thead>
            <tbody>
              @foreach ($saleProductDB as $saleproduct)
                <tr>
                  <td>{{ $saleproduct->cantProduct }}</td>                
                  <td>{{ $saleproduct->name }}</td>
                  <td>{{ $saleproduct->priceProductSale }}</td>
                  <td>{{ $saleproduct->subtotal }}</td>
                </tr style="margin-bottom: 10px">
                
              @endforeach
              
            </tbody>
            <tfoot>          
              <th scope="col"></th>
              <th scope="col"></th>
              <th scope="col">TOTAL:</th>
              <th scope="col">{{$saleDB->totalPrice}}</th> 
            </tfoot>
          </table>
        </div> --}}
    </body>

    <style>
      h1{
        text-align: center;
        text-transform: uppercase;
      }
      .contenido{
          font-size: 20px;
      }
      #primero{
          background-color: #ccc;
      }
      #segundo{
          color:#44a359;
      }
      #tercero{
        text-decoration:line-through;
      }
    </style>
</html>