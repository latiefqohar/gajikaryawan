<html>

<head>

  <meta charset="utf-8" />

  <title>Anil Labs - Codeigniter mail templates</title>

  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <style>
    h1{
        font-family: sans-serif;
        }
        
        table {
        font-family: Arial, Helvetica, sans-serif;
        color: #666;
        text-shadow: 1px 1px 0px #fff;
        background: #eaebec;
        border: #ccc 1px solid;
        }
        
        table th {
        padding: 15px 35px;
        border-left:1px solid #e0e0e0;
        border-bottom: 1px solid #e0e0e0;
        background: #ededed;
        }
        
        table th:first-child{  
        border-left:none;  
        }
        
        table tr {
        text-align: center;
        padding-left: 20px;
        }
        
        table td:first-child {
        text-align: left;
        padding-left: 20px;
        border-left: 0;
        }
        
        table td {
        padding: 15px 35px;
        border-top: 1px solid #ffffff;
        border-bottom: 1px solid #e0e0e0;
        border-left: 1px solid #e0e0e0;
        background: #fafafa;
        background: -webkit-gradient(linear, left top, left bottom, from(#fbfbfb), to(#fafafa));
        background: -moz-linear-gradient(top, #fbfbfb, #fafafa);
        }
        
        table tr:last-child td {
        border-bottom: 0;
        }
        
        table tr:last-child td:first-child {
        -moz-border-radius-bottomleft: 3px;
        -webkit-border-bottom-left-radius: 3px;
        border-bottom-left-radius: 3px;
        }
        
        table tr:last-child td:last-child {
        -moz-border-radius-bottomright: 3px;
        -webkit-border-bottom-right-radius: 3px;
        border-bottom-right-radius: 3px;
        }
        
        table tr:hover td {
        background: #f2f2f2;
        background: -webkit-gradient(linear, left top, left bottom, from(#f2f2f2), to(#f0f0f0));
        background: -moz-linear-gradient(top, #f2f2f2, #f0f0f0);
        }
    </style>
</head>

<body>

<div>

  <div style="font-size: 26px;font-weight: 700;letter-spacing: -0.02em;line-height: 32px;color: #41637e;font-family: sans-serif;text-align: center" align="center" id="emb-email-header"><img style="border: 0;-ms-interpolation-mode: bicubic;display: block;Margin-left: auto;Margin-right: auto;max-width: 152px" src="<?= base_url(); ?>gambar/logo.png" alt="" width="152" height="108"></div>

<p style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">Hallo ,</p>

<p style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px"> Terimakasih telah memberikan kontribusi selama sebulan penuh, Berikut kami cantumkan rincian gaji yang anda dapatkan </p>



</div>

<h3>Rincian gaji</h3>
	<table cellspacing='0'>
		<thead>
			<tr>
				<th>Nama Komponen</th>
				<th>Jumlah</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>Andi</td>
				<td>Jakarta Selatan</td>
			</tr>
			<tr>
				<td>Budi</td>
				<td>Bandung</td>	
			</tr>
			<tr>
				<td>Cahyo</td>
				<td>Bekasi</td>	
			</tr>
			<tr>
				<td>Darma</td>
				<td>Bali</td>
			</tr>
		</tbody>
	</table>

</body>

</html>