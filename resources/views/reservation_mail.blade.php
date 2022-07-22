<style>
  .justify{
    text-align: justify;
    font-family: 'Arial';
  }
  .td-margin{
    margin-left:3%;
    margin-right:3%;
  }
</style>
<div style="float:left;width:50%">
  <img src="{{public_path('assets/elite.png')}}" width="200">
</div>
<div style="float:right;width:50%" align="right">
<b>www.eliteparking.es</b><br>
Calle Gumercindo Llórente 77, Madrid</br>
28022 de Madrid<br>
Correo: contacto@eliteparking.es<br>
Reservas: +34 910 94 57 30<br>
</div>
<br><br><br><br><br>
<hr>

<div class="justify">
  <p>Hola {{$client_name}}</p>
  <p>Este correo electrónico representa su voucher de reserva <b>(NO ES NECESARIO IMPRIMIRLO)</b></p>
  <b>Elite Parking</b>
  <p>¡Su reserva ha sido registrada exitosamente!</p>
  
</div>

<table width="100%">
  <tr>
    <td colspan="2">
      <center>
        <p><b>Número de reserva:</b> {{$id}}</p>
      </center>
    </td>
  </tr>
  <tr>
    <td colspan="2">

      <center>

        <p><b>Total a pagar:</b> {{$price}} €</p>

      </center>

    </td>
  </tr>
  
  <tr>
    <th>Datos del vehículo</th>
    <th>Datos de la reserva</th>
  </tr>
  <tr>
    <td>
      <center>
        <p><b>Matrícula: </b>{{$plaque}}</p>
        <p><b>Marca: </b>{{$branch}}</p>
        <p><b>Modelo: </b>{{$model}}</p>
        <p><b>Color: </b>{{$color}}</p>
      </center>
    </td>
    <td>
      <center>
        <p><b>Recogida:</b> {{$reception_date}}</p>
        <p><b>Terminal:</b> {{$reception_terminal}}</p>
        <p><b>Devolución:</b> {{$devolution_date}}</p>
        <p><b>Terminal:</b> {{$devolution_terminal}}</p>
      </center>
    </td>
  </tr>
  <tr>
    <td colspan="2">
      <fieldset>
        <legend><b>Observaciones</b></legend>
        {{$observation}}
      </fieldset>
    </td>
  </tr>
</table>

<div class="justify">
    
  <h1>INSTRUCCIONES DEL SERVICIO:</h1>
  <ul>
    <li>
      Deberá llamar 20-30 minutos a nuestro número de asistencia en aeropuerto (+34 623 16 46 56). Nuestro personal le indicará unos sencillos pasos que deberá seguir para aparcar de una manera rápida y sencilla.
    </li>
    <li>
      Muestre este correo electrónico a nuestro personal, recuerde que debe dejar las llaves del vehículo.
    </li>
    <li>
      Nuestro personal realizara una breve inspección del vehículo y le entregara una copia de su contrato.
    </li>
    <li>
      A su regreso, una vez haya recogido su equipaje de facturación, deberá llamar a nuestro personal de asistencia en aeropuerto (+34 623 16 46 56). Deberá presentar la copia del contrato para poder recoger el vehículo, en caso de extraviar dicho contrato deberá presentar algún documento valido que certifique que el vehículo es de su propiedad.
    </li>
  </ul>

  <p>Pago: Online, TPV o efectivo.</p>
  <p>Gracias por utilizar nuestro servicio <b>VIP ELITE PARKING.</b></p>
  <p>Cualquier duda sobre nuestro servicio póngase en contacto con atención al cliente (+34 910 94 57 30) o en la dirección de email: contacto@eliteparking.es</p>
  <!--Letra pequeña-->
  <p>El depositante declara conocer las tarifas en vigor y aceptar las normas y condiciones generales del presente servicio promocionado en nuestra web. Elite parking se reserva el derecho de mover el vehículo entre otro parques e instalaciones de otras entidades concertadas para mejor optimización de los espacios de aparcamiento que dispone Elite parking. No nos responsabilizamos por roturas aisladas de cristales. La versión completa de las condiciones generales de nuestro servicio se encuentra en www.eliteparking.es.</p>
  <p>Sus datos son recogidos con el único propósito de registrar su reserva, facilitar reservas futuras y encuestas de satisfacción. En cumplimiento de Reglamento (UE) 2016/679 del Parlamento Europeo y del Consejo, de 27 de abril de 2016, puede ejercer los derechos de acceso, rectificación, cancelación, limitación, oposición y portabilidad de manera gratuita mediante correo electrónico a : contacto@eliteparking.es o bien en la siguiente dirección: Calle Gumercindo Llórente 77, Madrid, 28022 de Madrid.</p>
</div>
<center>
  <img width="300" height="240" src="{{asset('/assets/elite.png')}}"><br>
  <p>Copyright © eliteparking.es, todos los derechos reservados.</p>
</center>