<!DOCTYPE>
<html>
	<head>
		<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
		<title></title>
		<link rel='stylesheet' type='text/css' href='<?= base_url() ?>invoice/css/style.css' />
		<link rel='stylesheet' type='text/css' href='<?= base_url() ?>invoice/css/print.css' media="print" />
	</head>
	<body>
		<div class="card">
			<div class="card-block">
				<div id="page-wrap">
					<p id="header">INVOICE</p>
					<div id="identity">
						<!-- <div id="address">
								<p>GST NO : 24ANUPP1846N2Z7</p>
								<p>PAN CARD NO : ANUPP1846N</p>
						</div> -->
						<div class="logo-image">
							<img class="im" id="image" src="<?= base_url('assets/assets/images/logo.png') ?>" alt="logo" />
						</div>
						<!-- <div id="logo">
									
						</div> -->
						<div id="address1">
							<p class="mr-b-p">13, AI-Fazal Market,
								OPP. Winsome Hotel, Narol to Vishala Exit,Narol , Ahmedabad,Gujarat 382405
							</p>
						</div>
					</div>
					<div style="clear:both"></div>
					<table id="items">
						<tr>
							<th>Address</th>
						</tr>
						<tr class="item-row">
							<td class="description"><?= json_decode($book['address'])->address ?></td>
						</tr>
					</table>
					<br>
					<div id="customer">
						<table id="meta" class="meta-width mr-r">
							<tr>
								<td class="meta-head">Name</td>
								<td><?= $book['name']; ?></td>
							</tr>
							<tr>
								<td class="meta-head">Mobile No</td>
								<td><?= $book['mobile']; ?></td>
							</tr>
						</table>
						<table id="meta" class="meta-width">
							<tr>
								<td class="meta-head">Invoice No.</td>
								<td># <?= $book['book_id']; ?></td>
							</tr>
							<tr>
								<td class="meta-head">Date</td>
								<td><?= date("d-m-Y", strtotime($book['book_time'])); ?></td>
							</tr>
						</table>
					</div>
					<table id="items">
						
						<tr>
							<th colspan="4">Description</th>
							<th>Price</th>
						</tr>
						<?php $sub = 0; foreach (json_decode($book['services']) as $key => $v): ?>
						<tr class="item-row">
							<td colspan="4" class="description"><?= $this->main->check('services',['id'=>$v->service_id],'name') ?></td>
							<td> <?= ($v->price == 'Membership') ? ''.$v->price : '₹ '.$v->price ?></td>
						</tr>
						<?php $sub += ($v->price == 'Membership') ? 0 : $v->price; endforeach ?>
						<!-- <tr>
							<td colspan="4"  class="total-line">Subtotal</td>
							<td class="total-value"><div id="subtotal">₹ <?= $sub; ?></div></td>
						</tr> -->
						<!-- <tr>
							<td colspan="4"  class="total-line">SGST(9%)</td>
							<td class="total-value"><div id="total"><?= $book['price']; ?></div></td>
						</tr>
						<tr>
							<td colspan="4"  class="total-line">CGST(9%)</td>
							<td class="total-value"><?= $book['price']; ?></td>
						</tr> -->
						<tr>
							<td colspan="4"  class="total-line grandtotal">Grand Total</td>
							<td class="total-value grandtotal"><div class="due"> ₹ <?= $book['total_amount']; ?></div></td>
						</tr>
					</table>
				</div>
			</div>
			<div class="form-group row">
				<div class="col-sm-2 offset-3">
					<button type="submit" class="btn btn-primary" id="print-invoice" onclick="jQuery('#page-wrap').print()">Print</button>
				</div>
				<div class="col-sm-2 offset-3">
					<a href="<?= base_url('admin'); ?>" class="btn btn-danger">Cancel</a>
				</div>
			</div>
		</div>
	</body>
</html>