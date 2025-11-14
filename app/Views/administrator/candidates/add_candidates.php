<?php 
    $page_text="Add";
    if(isset($list_data[0]->id) && !empty($list_data[0]->id)){ 
        $page_text="Update";
    }else{
        $page_text="Add";
    }
?>
<div id="page-wrapper">
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-12 col-md-12 col-xs-12">
	        <h4 class="page-title text-center"><?php echo $page_text; ?> Candidate</h4>
      	</div>
    </div>
    <div class="row justify-content-center">
        <div class="col-12">
			<!-- <form class="form-horizontal form-material mb-5" method="POST" enctype="multipart/form-data"  action="<?php echo base_url('candidates/import_excel'); ?>" >
				<?php 	
				/* $csrf = array(
						'name' => $this->security->get_csrf_token_name(),
						'hash' => $this->security->get_csrf_hash()
				); */
				?>
				<input type="hidden" name="<?php //echo $csrf['name'];?>" value="<?php //echo $csrf['hash'];?>" />
				<div class="field-grp white-box add-basic-detail">
				<div class="field-grp-title"><h2>Upload Excel</h2></div>
					
					<div class="row">
					<?php // echo "<pre>"; print_r($list_data); echo "</pre>";?>
						
						<div class="col-md-6">
							<div class="form-group candidate-resume">
								<div class="single-field">
									<div class="upload-text" id="upload-text">
										<i class="fas fa-upload text-secondary"></i>
										<span>Upload Excel Sheet here</span>
									</div>

									<input type="file" class="file-upload-field" name="docx" id="upload_excel" value="">
								</div>
							</div>	
						</div>
						<div class="col-md-3">
							<div class="form-group text-center m-0 p-0">
								<div class="col-sm-12">
									<input type="submit" class="btn sec-btn sec-btn-outline" value="Upload">
								</div>
							</div>
						</div>
					</div>
				</div>
			</form> -->
			<!-- <form class="form-horizontal form-material mb-5" method="POST" enctype="multipart/form-data"  action="<?php // echo base_url('candidates/importData'); ?>" >
			<?php 	
				/* $csrf = array(
						'name' => $this->security->get_csrf_token_name(),
						'hash' => $this->security->get_csrf_hash()
				); */
				?>
				<input type="hidden" name="<?php //echo $csrf['name'];?>" value="<?php //echo $csrf['hash'];?>" />
				<div class="field-grp white-box add-basic-detail">
				<div class="field-grp-title"><h2>Upload Excel</h2></div>
					
					<div class="row">
					<?php // echo "<pre>"; print_r($list_data); echo "</pre>";?>
						
						<div class="col-md-6">
							<div class="form-group candidate-resume">
								<div class="single-field">
									<input type="text" name="text" id="text" value="">
								</div>
							</div>	
						</div>
						<div class="col-md-3">
							<div class="form-group text-center m-0 p-0">
								<div class="col-sm-12">
									<input type="submit" class="btn sec-btn sec-btn-outline" value="Upload">
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>
			<script>
				$('#text').val(JSON.stringify([{"name":"Pooja Pragada","email":"","phone_number":"9016438361","designation":"WordPress","gender":"","experience":"3","current_salary":22000,"expected_salary":30000,"upload_resume":"Pooja_Wordpress Developer_Surat.pdf","location":"","skills":"","resume_data":"data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wBDAAMCAgMCAgMDAwMEAwMEBQgFBQQEBQoHBwYIDAoMDAsKCwsNDhIQDQ4RDgsLEBYQERMUFRUVDA8XGBYUGBIUFRT/2wBDAQMEBAUEBQkFBQkUDQsNFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBT/wAARCACoASwDASIAAhEBAxEB/8QAHQAAAgIDAQEBAAAAAAAAAAAAAAUEBgIDBwEICf/EAEUQAAEDAwIDAwgIAwcDBQEAAAECAwQABREGEgchMRNBURQiMmFxgZGhCCNCUmKxwdEVcuEWJDNjgvDxF0NTJjRUg5Li/8QAHAEAAQUBAQEAAAAAAAAAAAAAAAECAwQFBgcI/8QANxEAAQMDAwEGAggGAwAAAAAAAQACEQMEIQUSMVEGEyJBYXEy8BQjM4GRobHBFWJygtHhBxaS/9oADAMBAAIRAxEAPwD4AQoLQlQ6EZFZVSTqedFR5OktjsvMCtvPA5CoL16nSjhUlw5+yk4HwFCFf3pLMcZddQ3/ADKApe/qa3sf97tD4NpJ/pVJTGkPHPZqOe9VSGrO+51IT86EJ8/rRsf4MZSvWtWPkK0wbs5dXnVuhKVDACUjkBUNnT6eq1KV8qawrc1ESdiduep8aeGlIod4hqkxjsGVpOQKSpt8lZ/wyPbVwKAax7EeFKGIlVlqyOr9JWPYKltWBsekSr308DeO6sginhgSSlzNpZb6IHwqY0wlHQVISwtXRBNbkwlnrhNOBDUKPivCkGphgjafOyfZUTpTw4HhCEozyAJ9lbUxXFfZx7a8ts5Dkt+Lkb0ALHrB/wB/OmVRGoQYCWFqgWSVc5jMSKy5KlPLDbTEdBWtxR5BKUjmSfAV65bvJXVtPIWh1tRQtCxgpIOCCO41Lt9wk2mfGmw3lx5cZ1LzLzZwpC0kFKgfEEA10PjfItGprlataWl+Kheo4xkXG2suJ7SHOQdr+UZylC1fWJJ67j4U4EuYXTkfojzXMktoT0SBUeW2E+eOh61LrFxAcQUnoaia8tMpVVrxcnIEiI80MhCju9Y8KtUAm6BjyVKn1P4DaEDKlE9AAO/1VW7pD7RDjSx6s/rWjSdyVGkLtzxwCSW89x7x7+tI5xcZKF9Q8Ovop3LUfZS9Vais+jLacKKZkxpUpQ9Te4BP+sgjwpTq7hzw34dX+VAues7jqVTatzbenYjJQUHmnMhbhTuxjO1Jwc1x/aPAV7VrvaIYGtp56kk/lgJsHquj/wDUDRdk5WLh3FkuJ6SdST3Zqj6y232TfxBpHq3ibedZQGoEtFuh21lztWoVttzEVtCsEZ8xIJ5EjmTVUoAyaYaz3CJgemP0SwFHkNbfPHQ9a00wICgQefqpalxDnnNq3IPonxFa9FlUUg97SAeDGD7dY81GSJgLKs6xFZVOE0orFQrKipQkS+XGBB+6arcmAqDLS83kIznI+yauS0ggg9DUN6KgJJUeVZVS1dTqCpTGBlSB0iClen7O1qPtVzpj63EK/wAHd3dx51aoemLZDxsiNqI+04Nx+dUR2TItF28paOOeU+BHga6ZpKZB1I/DD0xNvjuuJbfkKQXBHBOCopHMgdeXOr2mGjUO17Ru69U18hbW0JQnalISkdABgVtA5V1qdwPtytUO6VtV/lyNSdiZERubbktRbk3sKwqO6h5zO5AKk7gArGMg8qvET6O2nUR0Ki6lnXKK4A41MhWFc5p5JHJQWhtQT/JuJT34OQO3piAqxXxa9aWHHSstjcevrrNuC2gYCQPYKmkc6zRHcV0QffyryaAFfUZMdKe7FbA0B3VMRBX3kCtqYSR1UT8qXcAhQAgCs0oKugJ9lMUx209ED386zAxSb0JWRismkBxxKScZrOYAh8/iGaWXKYqI0h5Az2a0qPsB504nCbCeJiNp6gq9praltKPRSB7q9SoLSFJOUkZBr2opJTl0vRHAPUeuNH3fUDCU29iGyiRHNwKY7MxreUurS8tSUhLYGSTy7s5rn11t5tNxkQ1SI8osrKC9EdDrS8d6VDkR6622e+XKyPvKtkyREeksLhuFhZSXGnBhbZx1SodR31LuWidQ2azs3a4WK5QLW84GWpkqItppxZBISlSgAThJPLwqV21zRsaZHKT3SWlk9JaeyOiudM6jT2e1jkj0k8xUQJCVVSU+q2XVianO3O1wDvH/AB+VXNKgtIUk5SRkEd4qrXCMJMdaD3jkfXU3Sc8yYBjuH62OduD12937e6kQntdC0pcdJ6rsjGm9Rsx9O3BrIgamis4TknPZzEJ9NGejoG9PfuFc9rwnAyeQ8TUjHlh4lIU91jou7aDvKrZeIwZe2B1p1tYcZkNK9F1pY5LQruUPzBFI61OT2eQVISrAwBuzgeFSorAlpyhYxXS6b2Z1fWX7bC2c73gD8XQFXq3NKiJqOhLLlH7RvtAOaevsqpXiKppaZLR2rQQSR8jV+lR0oS41vO8jbkDkKXm0sLGHAXAeoJ5Vn6lpztLrfRq1RrqgkODTO0gxBMQT7Ej1UlOoKrdwGF7ZZxu1vbfCTu9FYA6KHWmHYKHpYR/McVHisIhM9jHSGm852o5AmvtPhL9Cazos8S463fkTZ76EuG2RnC00xkZ2rUPOUod+CADkc+tbemW9hcgNpWzqjwBuL3wwH2a0Ojp45XIdpO09j2XoNr6jU2hxIa1rZc6OYkxjzJgcZyF8abW09VlX8o/evQpAHJvP8xzX6RL+i7wuci9h/ZKME4xuS+8F/wD635r5c+k79HCHwlZh37T77zthlveTrjSFb1xnCkqThX2kkJV15gjqc8tm6OoWFI1bRlKmBzsYNw9nP3P/AAcuO7P/APJGh9ob1tg0VGVHfDvAhx6eFxE+49JlcBLy8YB2jwSMVpW2Fpwf+Kyori697dXlQVbmq57uriSfzlewNY1ghohQikpJB5EUVKfZ3oyPSFRRV9hD27gmnCKKKKkCRFa3WwtOK2UHnTiA4bXcFCR3CCH21IUP6UotdxkaeuG4ZKeikdyk1bH2Q4PxCklyt4kIPLCh0NYD2OtKoI48lKPEF2ew8YdTo0xGtttv0mPbUIW22lnal1CFHKmw4BvCMknZuxknlzqu1zTTl8dsk0oWCWFHC0eHrFXA6ytCDgyTn+RX7V3lpqNE0g6s4A/qqzmmcJfFWBJRnv5fKmdV913s3Gl9yXEqPsyM/LNWCvNSZVxFWWG1o+JEZcmP3q5ylICnI0ZpmI2hWOaQ8pTpVg8s9mKrVWPRGizrafIj/wAcs1hbjtds5JvczydvbkDCTglSufogZpzZJgBIlN3kwpc1S7fCXb4uAEsuPl5XrJXhOSfUAPVUKrJrjTVn0xOjRrRqiJqnc1ukPQozrTbLmSNgLgG8YwdwGOdVukcCDBSqDdEZaQv7pwfYaUy2w8ypB6KGKsEhvtmFo8Ry9tIvSTSIU3TckyLU2lR89klpXu6fLFNKrdhe8mu8iOThL6Q4nP3h1H+/Cn0iWxFGXnm2h+NQFIhWvh7rqZw71Gi7Q0rdUGlsraRJdj9olQ6FbSkrAyEnzVDOMZ5001txfvGuIr0WVCtUSO6QpZYiBx9WDkZkPFb3Uf8Ak599cvc1RCCtjJdlL+6y2TUK4ammRWwsW5TCDyC38/lyqQVHhuwHCSByrJWDrqGU7nFpbT4qOBVCk6muMjI8oLY8Ght+fWnWn7NDuEFEqTulPqJCu0USEnPT8qjSratTbxUWVBxsk7VDv51BZgXKHc/KITGQsYUHOST8SKtbMdqOgIabS2kdAkYrZSnJQk3kt5lf4sxmIk/ZYRuPxNZI02wpQXJfkS1f5rhx8BXarnobT+quEr+rtJxpFumWGQmPfbfNnJfPZO4DEhCtiPSXuSUAE+AwCTyypHNdSIM85BCTlKbnakIiFcVsNuI54B6jvqDAkTmyAh8tg/dFWSlL7Hk8ggeieaa6fS9dv7RwbTruaAfIwY9+VBUoseMtlOb/AGOZovV0uxT1rdWplmYw+4Mdqh1pLmR6vO5e+sKuN7ZXxN4QMz2PP1ToZI3d65FqUvl6z2LisepDnqqjwpaJ0Vt9HorGceB7xTO0Fn9HuzXaZZU8QJzzk56rL0i7fcUTSr/a0jtd7jhw9HNIcOkxyCt9fbvCD6Tw4haTTpSVc29Oa5MUsQ7rKaS5GfcSPNUQeQWQOYIwT0znbXxFXReC3BqXxpu9xtsG7wbZJiMCQG5e4qdTu2naEjoCRk924dc1V0i6uLevsoDdu5HEx6+R5XO9s9G0nVNO77VnbBR8TXxO04GWwQ5pMbmkQR05H3rF07ervw0ZsGq5SNVTJ+6NPn2paYoS0oqIcB5ZKcJHmgZ8MZrjH0odOWrQH0ebZp21NzJ1vYuiENSnZQcLLn1iiF+IIKwAAADj2HTorQnHfhdBRYY1usWrNPsKKmmJj6FISD3IKyhSR6iMDNbdTcI+KfHu+26FrSLA0Xpa25Whi3uoeKyeR2pStWVYGAVYCQTgHJB724f39qabKbu8cNsEcT1dwvnLS7e30nVmXdXUqBtKdQ1iGPAkgHbFFpkOzG1rYAwdwEL5Dt+l7xdbTOukK1TJdtg4MqWywpbTP86gMD30sAya+375xDkcFrW1o3R3Ce93jT7AW0/LnRHg3LKvTPJtW/dnmVYyOQTjFfJ3EDTt4i3eXeJejZukbbMeKmIrkR1phrPPYhS0jPecfAAcq4y805tq0bXbnD4hBgexiIX0X2e7SV9ZqPNegKVJ2aRL2Fzh/MwEua7ziMDByM1Ooslrarekcj1qVXpSFJIPQ1UoO2H0XdlLqKydbLSyk+6sa0CITEUUUUoQvCM1HkMbwVAc++pNFMqU21mbHJQYVbnW3tVBaMBY8e+lhs0hRJJSCauSoyFHOPdR5OgfZFZYsazhsc4QE/cOUrlI7RlSR3jFP4rvbxmnfvoCviM0iVzSa2wL/ChwwzIf7NxolJTtJOM8sYHhisdSJ7RSX+0hkf8As4EmT+Ip2p+NGb7L6JjQU+vz1fqKEJ11qLJucSJntpLaCO4q5/DrVKva7jGlGPKkreyNw2qO0j2UvbiurIIbJHgeVCFdVaoYcJTEjyJi/wDLRgfH+leRoUmQ2FuNBlSuZST09VN45QWGy0AlopBSAMACtlCEjkaXbmKQp15Sdv8A4xg/GpTGlYMZtDxilxKiQl17KgojGfUcZHxplXb+Oa3tU8NOFmo4Mtcy1M2cWZ9lvelqLMY/xPqzyQVJKcqHpbM9MZlYzc1zuiSVw1tpDKdraEoT4JGBWi5Qk3CE6woZ3Dl7RzFSqKiSqmt2xpockjI9XOpWmpZj3OTDWfNd+sR7QP2/Kps5jsZKwOivOHvpJcd0OQxMb9JpYJ9Y/wB/nSn0QrtRWDLqZDKHUHKFpCgfUazwaRC6Jwk1FcYcXU+m7Vb7fLlakgGCt+6TkxmGGgSpS/PWlBWCElKicpIOAc1UdWaWuWiNSXGw3djya5QHSy+1nIB6gg94IIIPeCDSnbXY+NBZ1ToHQWrpcyEnU70IW25RETGnJD6Gh/d5SkJUVDc2NqioAgpSMcxVkfWUz1b+k/5KbwVxyo8xntWiR6SeYqRivQDmoWO2OBSnKn8NNaOaE1bCuoZEqKCWZcRfoSY6wUutK9SkEj4HurDXekW+Guv5VoivGTYLghNws8tX/ejODc2fbjKT+JBFV+S2GJBAxg8wPCuhhLfEvg7LtLjqU6i0lvuVrWtQCnoaiPKGAT1KVYdSOvpgV6NQaNV051o/42eJvtzH7rlb0GwvaeoM+F0MqexPhd/a4wf5XOJ4Cp9WPQvEDUHDe7O3PTlxVbZrrKo63Utoc3NkgkYWCOqQendVWhOOPxGnHUFpxSfOSRjBqRiuApvfReHMMELo69vRuqTqNdgex2CCAQR6g4K+zeEn0Yb7qGfC1br/AFG9cESgJn8NYkLWXtw3J7VzIGOfNKcjuzjlXMePv0kNS3rWsq06fnTNN2ayvriNNQXiyt1aCUKWsoI5ZBAT0A9dcQg325WtxDkO4Soi0JKErYfUgpSeoBB5CoJJWokkknmSa6OtqoNAUraW5kkmSfvXnVh2QqfxR2o6vWbcBo202d2GtpgnMNkgmIEnPrwuv6S+lbxH0xMZW5fFXmIhQ3xLkhLgcHhvxvHuVXvG36Sd94yMsQDHTZbG2ErVb2nO07V0Z89S9oJ68k9B15muQUVW/iF0+maTnkg/PPK6FnZXQ6d6zUadoxtVnBDQPvgQCehIkeRQBms6Zad0xdtVzVQ7NbpFzlJbU8pmM2VqCE9VEDuGR8aXFJGMgjIyM99RNYQAYwukFSm55phw3CJE5E8SPWDHstb7Aebx9ocxS8jBweRprUaYxy7RI/m/etBniEJSodFFFJwkRRRRTkIr0DNeUU+ULFFraA85Sl/IVm3bIjSytMdveftFOT8ak11SH9Hy6i+26x3jUOntP3y4lpMS2y5TjzzincdkD2DbiUbsjBUodRXHtY5/AVhcsoqde7NJ09erhapoSmZBkORXkoVuSFoUUqwe8ZB51CxTSIwhJb7GSt1l0jngpJ/L9aXKZSEHAp/d2t8MkDmhQV+n60nxlNLKEw026XrU2gnKmSWj7jy+WKabaQacd7KfLjnosB1I+R/SrBTULzbXV+DltuWqNM6ytf8AbG8WOwW6Au7TbRbEl0zmk4S6Q2XW0chs3ZPMY5HFcproHAjW0PQXE+03C6qAsb/aQbklSSpJjPILa9wAJITuCsAZ82p6JAqDdwkPC5/iinWrrXZrRenI9ivX8ft4GUzPJVx8nJ5bV4UcDHPA69KS1CRBhKoN2Z3NJcHVBwfYaRzGQ+ytB6EYqyy1tIYX2ziW2yMFSjiq+MLQD4ilIwChbtHzC5CciuH6yOrH+k/1z8qf1R9s6Fcu3gNrWpacKCUbgfb8qbN32S04Eyk9koAZQU4rZ0nTDqtfue9aweZdP7KKpU7sTEqxEgd/PwrJLTi/RbOPE8qiJ1VCDICT56iE5CeQyQMk1LUtS/SJPtrtdW0fs92cqMpVazrt7hu8BaxgyRBP1jpxwAMR1VKlVuLgEhoYPXJ/ZZdiB6bqU+pIz86Pqk/ZU4fxnl8K10Vhf9kFtjTbSlR9dveP/wDVUvg/0gKb6Pu+0eT98D8oWtcZpx5ThQMnu7h7qzCEpGAkAeoVY9McOtUazUBY9P3G6JJx2keOpTY9q8bR7zUrWPCjWHD9ht/UOn5lsjuHal9aQtonuG9JKQfVnNc9XfeXbn3Vfc7cZJgxJ/JQC/sKdYWffMFTybuG78Jn8lU6yHSrppng5qfVNqZurMaNb7S+stsz7rMahtPKBxhBcUCvny80EVdeH30b5OodW3vTmpLmvTd4tLTctcARw+uTGyN62lpVgkJIxgHJUPXhaVjc1S3aw+LicDryVn3naLSrFtR1a4b9XlwB3OGQD4WycEgHGJzC5OrT10RY0XpVulJtC3vJ0ziyoMqcwTsC8YJwDy9VRIsV6a8hmOy4+8taW0ttJKlKUo4SkAdSTyA767/w01Roq/3e6cNYSLjC0bqVhLUd27uIcej3JJPZvjZhKQrDacDvCR0Jqw8TOH0TUlqtPDjRWoYKLlpbciVY5qTEfuEojKn23Fea4easJyMAnngitRmm76feU3boxA5Lug+7P7Lm6na02t59DvKBpz4txB2tpEYe8gOAIf4CCQBhxcAVySy/R81hc9vlrELTinHvJ2G7/LTDckO4B2NoV5yj5w7sc+tWbhn9H525u6xOo7dcJFy02plo6fgvtMPPrcJwpTq8pS2EjduGcjmDy57uMmomte8PLHOvtwTA1/pxw2qdbJDn1kprkUvoAyM9Mnocq8E5iXn6RkuUxpy8QW3mNZxYarbd5L6EORLpGBOwOoOdysdSQOpx3YvspWVCp45gQc+YPpGCD5ehWW+67S6nafUbWueS0wHAMLXAgh26XU6rARvbBaXNIjMW9MO2cG4q9VaJEBep4yP77YZDybyqEznCnUSGEgNebuCt/LBPPIGYvGzSF64zfwzXullfxXTj0ElyMt5ps2hxsZcYVkp5ZyR1yScciM83u/Gy6TdP3CzWuzWLS0G5JCZwscIsrlJ+4tSlKO3mfNGBzI6E1z3cdpTk7Sckdxqepd0S3uWjwHyGMz7fjj2VjTuzl8y4bqVV4bcNJAc4d4TTIHhOQRtPwHe5wE7nHcQDHLNZYyMHnRXqapU16WlkljsF8vRPStNNZQbLCi6sISBnco8hSqpagHISIoooqEJUUUUU4FCm123iBx7fdh6Rc0pKjQrrH0/FhXO4t25tM5MltJQoIkqR2iRt280KHMnnXEqK5Jr3MBDfNTwslrU6tS1qK1qJKlKOST4k1jRRUaVYPN9sytH3kkVXW/RxVkUtKElSlBKR1JOAKrYeafedUyoLbK1YI9tL5IWplzyW8Q3eiVKLSv8AUOXzxVqqo3FhbzCg0lRcHnJ2jnkc6hTb7emEJQ+Vx8jkezCSr34pEK9LcS0kqWoISO9RwKVytT22LkGQHFeDQ3fPpVCdfflry4tx5X4iVGrTpOzxXorjz7CXHwvGHBkAYGOVCFkvWLslRRAgOPK8VZPyH7152Wo7l6S0QkHwISflk1Z0IS2kJQkJSOgSMCvaEKtM6MStYcmTHZC+vLl8zmnrFvYjpAS2DjvVzrpvDTh9pzVFt/iuoNS/wmDGusaDOjtoSHW47wUEyErUcEJWAFDacJyrwFUO5RUQbjKjNvtym2XVtpfaOUOAEgKSe8HGRUhY4NBPBSSowGBgchSu929ElLbxSCpHmkkd3/P500rxaA4hST0IwaWm7a4E8IKf8G9K2/V1xvGn5KEmdc7Y8xblqA5SklLiE8+hX2Zbz/mVWoal9kW3AQ80S2sHrkVjp+6SdPXmLNjOliXEeS624nqlaSCCPeAavvGe2R2dXxNTW5tLVm1VGTcGko9Fp8kh5r/S6HBjwKa9WuLClqfZvvaLR3tAknqWnn3xkdNp6rlhWfZ6t3bz9XWGPR7eR/c3IH8riqXRRRXki6pfSVv1Jd+Kv0Y5MKDdZrN90UoKfjx5C0CZbyDgqSCArYAeucBvxVWj6JM+6alul+0tdUvXLQ823u/xBMklUeKoAbVhR5IV16YPf9nI5Fwx4m3XhTqJy72lEd9x2M5FdjS0lbLqFDopIIzghJ693tpnq7jvrTWduXbJd18js6ht/hltZRFj7fulKACoepRNdTSv6X1deo87miC0cOjiSTGRg88Lym77NXrqd3pdpTYKFZ29rySHU3Oy7a0NyWvBezxNA3RMCF0Lh7dbHedASUzL/YperbRIES1I1m7/AHGLAAT5zDZBQpZI6EH0Ry8WevOO1ki3DRV8tt1eveudNuCPMuMeII8S4xyMuIHQhI3KSk7B1UcDIr5sHSioBqlQUwxrQDjOfLg+46menC2H9j7OrdG5rvc4S4hvhAAe3a5vE7CCTtECSXGXQQ91lqGJqDWFyvVqtxsUeVIMlqG2/wBp2CicnaoJTy3ZIAAxnHdWrVOrrvrW9OXa9zV3C4uBKVvrSlJIAwPRAHIUnrxbiGk7lqShI6lRwKod690yeTJ8hPsuwpWlCiKe1uWDa0nLgMY3GTmBOcwCZKzAxXtJ5eq7bEyO37ZQ+y0M/PpSWVrtxZ2xYwSe4uHJ+ApA9reVbhXSo0q6RIP+PIbbPgVc/hVNKNRXrr2rbZ8fq04/WpcTQK1kKlygD3paGfmf2qZtSo74GpIHmpszXkNnIYbckK8T5o/37qVq1XeLqoohMFA/yUFRHtNWOHpS2wsERw6ofadO75dPlTdDaUJCUpCUjoAMAVabQrVPjfA9EkgcKmQdL3S4zGHbm6oMBaVLSpzKynPMDqAcVZZMFTSCtKt4HUYximSa961sW9sym0sHmoiZMpF1orfNjeTO5SPq1dPV6q0VVe0sdtKciiiiklCmkgDJOB4ml8q/2+HkOSkFQ+yg7j8q5/JnyZh+ufcd9SlEj4VbrLpaF5Ew++jt3XEBfnE4GRnGK5BWFg/rZpStkSK4+o9N3L5DNavKtRXL/DZENB7yAk/Pn8KszEZmMnay0hoeCEgVsoQqunSEmWoKn3Bbh+6nKvmf2pxBsUS3tbEJUsZzlw5q5WyXpZrR12Znwbi/qh1xH8PktPJTFZQCCven0lKICgO7nnuqu0pEIXiUJQMJASPADFL79DRMg4UkK2KChn4frTGsXEB1tSD0UCKBzlCqaIaUJ5AAeqpFhkFi8OxyfMebBT7R/wAmvUg8weo5GoMtzyKXFlj/ALTg3fynkaChXOijOenOikQiiirXcbHp5PDaz3iFdFq1Eqc/FuFsecR5qAlKmnW0gBWwjIJJPnchjHNwbM+iFVKKKKahQJ7fZvJcHRXI+3/f5V1DTTf/AFC4PX3TpO+62BRvduP2i1yTJbHuDbmP8tVc5ktdsypI9LqPbTnhbrJeh9Z2u7pQHmmHcPsHo8yobXGz6lIKk++vV+xmoinXFCplrxtIPn/o8H0JXNa5aVK9qX0PtGEPb/U3MezstPoSk8Z7yhhC8YJHMeB7xWynXFPT0bhtxAuVrS+FWqQoS7dJV6LsdxIW2rPrQpPvBqmy9WW+LkBxT6h3Npz8zXDa1pp0rUKtoMhpwerTlp/Aha9jd0762p3VL4XgEfenFegZNU6Trd907YsdKM8gV+cfhWjya/3n0+1Q2fvns0/CsYBXlbpd3hQs9tJbQR9nOT8BSaXriK1kR2VvHxV5oqNE0ITgypXtS0P1P7U6iaat0PBTGS4ofad878+VPHokVcVqO8XVRTEaKR/koz8zXrek7rclBct4N+txe9XwH71dUpCEgJAAHQCsx0qUNnlJKrsTQ8JnBfW5IV4E7U/Ac/nTyHbosEYjx22vWlIz8a316npVpjAPJNJXtZJrGsh0q8wJpXtZ1gOtZ1fpphXqayHWsU9KyHWtGmmlYvspfaKFdD3+BpI42phxSFjBFP6jXGJ5Q3vSPrE/MeFOr0O9ZLeQkBhKKK8BzXtYqkVaRAQ0OSQPZVlsznaW5vxSSn4E0nIymmGn1/VSEeDmfcQP2NckrCa0UUUIVk0dxAvOg0XdNndZZ/isNcCSp1hDpLSvSCdwOCRkZ8CardMLAi2uX23ovLkhq0KkNiY5EALyGdw3lAPIqCckA1v1b/A/7ST/AOzXlxsW/wDuhuQSJG3Azv28s5z07sU8yW5PCRKKKKKYlSKc32U1wdyvOHv/AK5qBPY7aO4jxHKnN5bwWnP9J/MfrS1wZTTncyhNdPy/LLRGWTlSU7Fe0cqYVXNLO9jKmxD0yHUD1Hr+lWMkJBJIAHUmmoRRS2XqK3w8hchK1D7LfnH5Uml65HoxYxJ7lOn9B+9CFa60yJjERO555DQ/GoCqp/6iu/3ozZ/+sfvW+NoferfLlqWo9Q2P1P7UIU2VrKCxkNb5Ch90YHxNbYbi5JDqEkhXneaOQzW6Jp23w8FEZK1D7TnnH50yAAGAMDwFaFreOtMsGZB/BMc3dyrNr+8WviBw001AliSzqqyKXERJDYU07CJ3oSo7shSFKWAAMYPXlXOoujILPN5TkhXgTtT8B+9P6Ktapqlxq9f6RcRuiMCPn5HCp2VlSsKZpUZ2kl2fIuMmPSSceS0RoMeGMMMoa/lTg/GpIGBXg60x0/aVX6/W22IVsXMktxwo9ElagnPuzWW0SYCvqBRVonaWiXVEyZpeQ9Oix0redhSUhMthpPVZA5OIA6qTgjmVJSOZ7tpDTmkWtFaWk6eg8P70JERK787rC6liY3Jz57aElQ7JI+ypKST159TcpUTUMSmEr5jU0tDaFqQoIXkJURyVjrg+8VYbZomZedOi5wJEWZIM1EIWlhalziVAbXA0E+gVKSkHPNSsYr6YsOlpEPR9w01qHTtqvtxs0aVqTRrbUkzIEmOsYeYQrOXUoJSsIUcqOM8uq3Q+tdMS9P2/VjkK22OBcFq0zrO0W8JjMrad5x5zTQPmlB5kpGRhWMYJq822AI3H5+fyymylOrfo6aV4c6t0yzqK6uQNOOgLuE64XBtp+UC1uPYRm21uthCgpJ3g5OBuTnNct408OIfCvWq7DDuMi6oQwh8ynoyWULC8qSWyFqC0bSnzuXPcMDFNtU60ssjhxN0TPlvXudYLqtzTt7ioBbdjOKPbNuFRCkpOAsYBO445AUou3F65X7Q0HTdytVnnqgxxDjXiRFKp7MdK96WkubsAA8hyztJHeczuNMyGiPnhNyqJWY6VhWdDEFejrWVYjrWVX2JpXqelZDrWKelZDrV+mmlZVkOlRZdwjQU7pD7bI/ErFIJ3EGBGymOhclQ7x5qfiae+9t7f7R4/UpA0nhM7nE7JfaoHmqPMeBqHSm36nmahndipCW2UpKg2gEknp195pspKmzhSSk+ChisZ9ancE1aQIapIIwUoHo1Jsi9k15H30A/A/wD9VGR6NZ29XZ3Rn8QUj5Z/SuQVhWGiiihCKvnFzWtk1zcLHLs1liWNUe2Nx5jECMI7CngtaiUJBOcJUlJUeaiknAGKoS1pbSVKUEpHUk4FK5ep7dEyC+HVD7LQ3fPpTg4gFvVCa0VUpGt3HVbIcTKj0Kzk/AfvWrsdRXf0lLjtnxPZj4DnTUKw3qXHZjhtbiQ6tQCEA885/bNLOqa1wtEhDiXJMpS1g5w2MfM/tVhagsMjk2D61c6UmUKnzYU1Upp6ChztQCnc3yx763DTF2uPnTZW38K1lZ+A5VcelFIhc3m2STClKYUkKI5hYPIit9tiiBNYkPEFCFgkY5DnjPu61bL3GC+yd8PNJ+Y/WkFzY7SI4lPXGR7qeWxBQrpRS+wTfL7THcJysJ2K9o5f1phTEIooopQhFFFFOQvU0y0/fJGm71DucRLSpEVwOIS+2FoV6ik8iCKXDpXtSNkGQkK6PC0s7YdUM3qEqE1pd/61pdxnNtB6I6khxggnetQQpbS9iVEKCsd1a9Oa507ow3uyzNK2nXVldllcadJDsWThJIQpLqcLSlQ5lB7zXPKKtNfHwhNhdD1Xxw1BqG7WSXbQzpWPYmHI1qiWQqaTEQsYcwskqKlDkVE8/VVAWouLK1EqUTkqPMk1gmsql3OeZcUIHWsqxHWsulTtTV6OtZUsm6gt9vz2slG4fYQdx+ApDO4gpGUxIxV+N04+QpxuKTOSiCVck9aizbxCt4zIkttn7ucn4VQzcL9fyQ12xbPc0Nifj/WpkLh/KeIVLkJZB5kI89X7fnStuq1TFFn3lG0DkphN4hRmgUxWFvK+8vzR+9Jl6ivl8WURgtKT9mOjp7TVrgaNtkLBLPlCx9p47vl0p222lpAShIQkdEpGAKsttLmv9tUgdB8/5TdwHAVAiaDuU5XaTHksZ67lb1/799WK36DtkTCnUrlrH/kOE/AVYayTWvb6bbUs7ZPrn/SYXuKwjxmoqAhlpDSPuoSAK3KSCeYB9tY1l1roacAQFCqC0fNrXIkeRqRI27uyUFEDvGefyzUqBb5LjLZU2UZSM7+WKmKsSH0KS84SlQwQnl868eWgl8jXMVCfqWHXFeCsJA/OlErWM+RkN7I6fwjJ+Jq1xLBAhYLcZBUPtLG4/OlWpLOwt5l5LYQVAhW3kD4UoEoVSkS35asvOrdP4lE090rYmJ5ddlIKwggJbOQD6zWTMBtoeagD2CmVhd7G4rZ6BxvcPaD/AFpEJ5HiMRU7WWkND8CQK20UUIT7QmjZ3EHVtt0/blsty5zhQl2Qra22kAqUtR8AlJPurrCuB+irnpDW0yx6ruky4aUYLsiZKgIZt8lYJHZNK3FW5RBCc9cjlzrhNdVuOrI8/wCjlaLC3dYMJ+BeHXHLUyHPKJoUNwfc+zhOUpTnJ5HmMYq1RLIIcJwfn900yuVUUUVVTlpms9vFcQOuMj2jnVbWNyatVV6Yz2EpxGMDOR7DT+W+yRR9JP8Ak02XBVyB+sQPz/T4Vaao7z38OukWWOSQrav2f8Zq8A5FMSoooopwQiiivR1pwQsqKKwdeQwkqcWltI71HAp4SFZ0Ukmavt0TIS4ZCvBoZHxpHL1xLfO2MyhkHoT5yqdvASQrwVBCcqIA8TSyZqe3Qsgvh1Y+y1539KqSbXe74Qp0O7D3vK2p+H9K3TNFS40YupdbdKRlSRkYHq8acH1HfCEKVN144rIixwjwU6cn4Ck6Zt11FJDCXluqVz2A7Ugeuhqzd7iifUKmW2czYrqyQAEq81z1JP8AvNQbi4jecJYjhTYPD9SiDLkhPihoZPxP7VYYOl7bAwURkuLH23fOPz5UzSQcEcxWVb1KhTbkBRElepAHIcgO6sqxT1rKtRiYV6npXtWvhvwzvPFC8PwLQI7SIzJky5sx3so8ZodVuL7h8T8DVpunAWRA/hcmBqawaotsqe1AcXZbggutuLVgJ2OFGSeeOePHA51eYmrlwpmvTd1ZsDN8ct8hFneeMZucpshpboGSgK6E4B+Fds1d9GO1aN1zZrbcdaRY1lvcksQHw32r4G3kpwDCAntMIJCjjIOME4fiVovRms7rwclRrjE05PAhzZ9zdCi3cBgszG04AQk5APcU7SeQObjTCavmSvQcCnOtNIXHQWqLjYbs12U6E6W149FY6pWnxSoEEHwNJavNKYlNFFFeQrQRS2/IzEQv7jgJ9hyPzIoop7OUJWOYrW0vye6Q3Og7TYfYoY/PFFFNJlCtVFFFIhFTrFa13y+W62tZ7SZJbjpx4rUEj86KKc0S4BCsnGHSts0PxMv+n7O6+/b7a+IyHJKgpxSkpSFkkAD093dVNoop9UAVHAdSkHCKV3prCm3R3+af0/Wiims8x6f7SpBc4/bxlpA54yPbVg03N8utDCicrQOzV7R/TFFFMQmdFFFOQtUiWzERuedQ0nxWcUmma0gxshkLkK/CMJ+JooolCSSdYXGarZHQGc9A2ncqsGtOXe7LC39yAftSFHPw60UUrRuOUJxC0LGawZLy3z91Pmj96exLZEgDDEdts/eA5/HrRRVlrQE1Ta860UVabhIVXZkARn1p6I6p9lVu+xcFL6R05KooqrdMaxwDRzlK3Ktejbt5fb+wWrLzHm8+9Pcf0qw0UVp2bi6mJUbuV6nrWVFFa7Ewrrf0dtYWez3fUGmtRSPIbHqq3Ltj07/4zhz2bh/CCSD3cwTyBp3pz6Jur16/i2y9291nTYc3yb7Eeb7DycAntELORzGMAjPPoOtFFaFMTymFYwdcaHRaL5w+1U9dLlpm1XV2Rp+72wNrktoC1BSMqwNjicHwyScdMU3ixxMa4lSLU6bepuVbmDDNzfczImspUexLwA270owCRnJz3YAKKssSKsah1RdtWzGpd5uD9ylNsoYQ7IXuUltPopz4CllFFXGppX//2Q=="},{"name":"Pooja Pragada","email":"","phone_number":"9016438361","designation":"WordPress","gender":"","experience":"3","current_salary":22000,"expected_salary":30000,"upload_resume":"Pooja_Wordpress Developer_Surat.pdf","location":"","skills":"","resume_data":"data:image/jpeg;base64,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"}]));
			</script> -->
            <!-- <div class="white-box"> -->
                <div class="massge_for_error text-center"><?php // echo $this->session->getFlashdata('message'); ?> </div>
                 <form class="form-horizontal form-material" method="POST" enctype="multipart/form-data"  action="<?php echo base_url('candidates/insert_data'); ?>" id="candidate-form">
				 		<input type="hidden" name="<?=csrf_token();?>" value="<?=csrf_hash();?>" />
						<input type="hidden" name="id" id="id" value="<?php if(isset($list_data[0]->id)){ echo $list_data[0]->id;} ?>">
                    	<div class="field-grp white-box add-basic-detail">
                    	<div class="field-grp-title"><h2>Candidate Detail</h2></div>
                    		
                    		<div class="row">
							<?php // echo "<pre>"; print_r($list_data); echo "</pre>";?>
	                        	<div class="col-md-6">
	                                 <div class="form-group">
	                                    <div class="single-field">
	                                        <input type="text" name="name" id="name" value="<?php if(isset($list_data[0]->name)){ echo $list_data[0]->name;} ?>">
	                                    	<label for="name">Name*</label>
	                                    </div>
	                                </div>
	                            </div>
	                        	

	                            <div class="col-md-6">
	                                <div class="form-group">
	                                    <div class="single-field">
	                                        <input type="email" class="email" name="email" id="email"  value="<?php if(isset($list_data[0]->email)){ echo $list_data[0]->email;} ?>">
	                                    	<label for="email">Email*</label>
	                                    </div>
	                                </div>
	                            </div>
								
	                            <div class="col-md-6">
	                                <div class="form-group">
	                                    <div class="single-field">
	                                        <input type="text" class="numeric contact_number" maxlength="10" name="phone_number" id="phone_number"  value="<?php if(isset($list_data[0]->phone_number)){ echo $list_data[0]->phone_number;} ?>">
	                                    	<label for="phone_number">Phone No*</label>
	                                    </div>
	                                </div>
	                            </div>

								<div class="col-md-6">
	                                <div class="row cms-option-gender align-items-center">
										<div class=" col-md-4">
											<label class="m-0">Gender *</label>
										</div>
										<div class=" col-md-4">
											<label class="cms-option-box male" for="gender">
												<input type="radio" <?php if(isset($list_data[0]->gender) && $list_data[0]->gender == "male"){ ?> checked="checked" <?php }elseif(!isset($list_data[0]->gender)){ ?> checked="checked" <?php } ?> name="gender" value="male" id="gender" class="radio-class gender">
												Male</label>
										</div>
										<div class=" col-md-4">
											<label class="cms-option-box male" for="gender1">
											<input type="radio" <?php if(isset($list_data[0]->gender) && $list_data[0]->gender == "female"){ ?> checked="checked" <?php } ?> name="gender" value="female" id="gender1" class="radio-class gender">
												Female</label>
										</div>
	                                </div>
	                            </div>
								<div class="clearfix"></div>

	                            <!-- <div class="col-md-6">
	                                <div class="form-group">
	                                    <div class="single-field">
										 
	                                        <input type="text" name="designation" id="designation"  value="<?php // if(isset($list_data[0]->designation)){ echo $list_data[0]->designation;} ?>">
	                                    	<label for="designation">Designation </label>
	                                    </div>
	                                </div>
	                            </div> -->
								<div class="col-md-6">
	                                <div class="form-group">
	                                    <div class="single-field select-field">
	                                       <select name="designation" id="designation">
	                                            <option value="">Select Designation</option>
	                                            <?php foreach ($designation as $key => $value) { ?>
	                                             <option <?php if(isset($list_data[0]->designation) && $list_data[0]->designation == $value->id){ ?> selected="selected" <?php } ?> value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
	                                                    
	                                            <?php } ?>
	                                        </select>
	                                    	<label>Select Designation*</label>
	                                    </div>
	                                </div>
	                            </div>
	                                            <?php foreach ($designation as $key => $value) { if(isset($list_data[0]->designation) && $list_data[0]->designation == $value->id){ ?>
												 <p class="d-none" id="<?php echo $value->id; ?>_skills"><?php if(isset($list_data[0]->skills)){ echo $list_data[0]->skills;} ?></p>
												<?php }else{ ?>
												 <p class="d-none" id="<?php echo $value->id; ?>_skills"><?php if(isset($value->skills)){echo $value->skills;} ?></p>
												 <?php } }?>
								
	                            <div class="col-md-6">
	                                <div class="form-group">
	                                    <div class="single-field">
	                                        <input type="text" maxlength="10" class="numeric experience" name="experience" id="experience"  value="<?php if(isset($list_data[0]->experience)){ echo $list_data[0]->experience;} ?>">
	                                    	<label for="experience">Experience*</label>
	                                    </div>
	                                </div>
	                            </div>
								<div class="col-md-6">
	                                <div class="form-group">
	                                    <div class="single-field">
	                                        <input type="text" maxlength="10" class="numeric" name="current_salary" id="current_salary" maxlength="10"  value="<?php if(isset($list_data[0]->current_salary)){ echo $list_data[0]->current_salary;} ?>">
	                                    	<label>CTC*</label>
	                                    </div>
	                                </div>
	                            </div>

								<div class="col-md-6">
	                                <div class="form-group">
	                                    <div class="single-field">
	                                        <input type="text" maxlength="10" class="numeric" name="expected_salary" id="expected_salary" maxlength="10" value="<?php if(isset($list_data[0]->expected_salary)){ echo $list_data[0]->expected_salary;} ?>">
	                                    	<label>Expected CTC*</label>
	                                    </div>
	                                </div>
	                            </div>
								<div class="col-md-6">
	                                <div class="form-group candidate-resume">
	                                    <div class="single-field">
											<div class="upload-text" id="upload-text">
												<i class="fas fa-upload text-secondary"></i>
												<span>Upload resume here</span>
											</div>

	                                        <input type="file" class="file-upload-field" name="upload_resume" id="upload_resume" onchange="getFileData(this)"  value="<?php if(isset($list_data[0]->upload_resume)){ echo $list_data[0]->upload_resume;} ?>">
											<input type="hidden" name="upload_resume_name" id="upload_resume_name" value="<?php if(isset($list_data[0]->upload_resume)){ echo $list_data[0]->upload_resume;} ?>" >
											<?php if(isset($list_data[0]->upload_resume) && !empty($list_data[0]->upload_resume)){ ?>
												<a target="_blank" class="view_resume" title="View Resume" href="<?php echo base_url('assets/candidates_upload_resume/').$list_data[0]->upload_resume;?>"><i class="fas fa-eye"></i></a>
											
											<?php } ?>		
									   </div>
	                                </div>	
	                            </div>
								<div class="clearfix"></div>
								<!-- <div class="col-md-6">
	                                <div class="form-group">
	                                    <div class="single-field">
						<input type="date" name="interview_date" id="interview_date" autocomplete="off" value="<?php if(isset($list_data[0]->interview_date)){ echo $list_data[0]->interview_date; } ?>">


	                                    	<label> Interview date *
	                                    </div>
	                                </div>
	                            </div> -->
								<!-- <div class="col-md-3">
	                                <div class="form-group radio-group">
	                                    <label class="m-0">Interview status </label>
	                                    <div class="form-radio">
											<input type="radio" <?php if(isset($list_data[0]->interview_status) && $list_data[0]->interview_status == "pending"){ ?> checked="checked" <?php } ?> name="interview_status" value="pending" id="interview_status" class="radio-class gender"><label for="interview_status">Pending</label>
										</div>
	                                    <div class="form-radio">
	                                        <input type="radio" <?php if(isset($list_data[0]->interview_status) && $list_data[0]->interview_status == "reject"){ ?> checked="checked" <?php } ?> name="interview_status" value="reject" id="interview_status1" class="radio-class gender"><label for="interview_status1">Reject </label>
	                                    </div>
										<div class="form-radio">
	                                        <input type="radio" <?php if(isset($list_data[0]->interview_status) && $list_data[0]->interview_status == "complete"){ ?> checked="checked" <?php } ?> name="interview_status" value="complete" id="interview_status2" class="radio-class gender"><label for="interview_status2">Complete </label>
	                                    </div>
	                                </div>
	                            </div> -->
								<div class="clearfix"></div>


	                            <div class="col-md-6">
	                                <div class="form-group">
	                                    <div class="single-field">
	                                    	<input type="text" name="address" id="address" value="<?php if(isset($list_data[0]->location)){ echo $list_data[0]->location;} ?>">
											<label>Location*</label>
	                                    </div>
	                                </div>
	                            </div>
	                            <!-- <div class="col-md-12">
	                                <div class="form-group">
	                                    <div class="single-field">
	                                        <textarea rows="4" class="textarea" name="address" id="address"><?php if(isset($list_data[0]->address)){ echo $list_data[0]->address;} ?></textarea>
	                                    	<label>Address </label>
	                                    </div>
	                                </div>
	                            </div> -->
								 <!-- <div class="col-md-12">
	                                <div class="form-group">
	                                    <div class="single-field">
	                                        <textarea rows="4" class="textarea" name="feedback" id="feedback"><?php if(isset($list_data[0]->feedback)){ echo $list_data[0]->feedback;} ?></textarea>
	                                    	<label>Feedback </label>
	                                    </div>
	                                </div>
	                            </div> -->
								 <div class="col-md-12">
	                                <div class="form-group">
	                                    <div class="tag-group">
	                                        <textarea rows="4" class="textarea tagarea" name="skills" id="skills"><?php if(isset($list_data[0]->skills)){ echo $list_data[0]->skills;} ?></textarea>
	                                    	<label>Skills*</label>
	                                    </div>
	                                </div>
	                            </div>

                        	</div>
                    	</div>
	                    <div class="m-t-30">
	                    	<div class="row">
	                            <div class="col-md-12">
	                                <div class="form-group text-center m-0 p-0">
	                                    <div class="col-sm-12">
	                                        <button type="submit" class="btn sec-btn "><?php  echo $page_text; ?></button>
	                                    </div>
	                                </div>
	                            </div>        
	                    	</div>
	                    </div>	
				</form>
            <!-- </div> -->
        </div>
    </div>
</div>
<div class="msg-container">
    <?php // $html = ''; $a = explode('</p>',$this->session->getFlashdata('message')); $a=array_filter($a); if(isset($a[0]) && $a[0] != ''){
        // for($i=0; $i < count($a); $i++){
        //     if(!empty($a[$i]) && ($i+1) != count($a)){
        //         $html .= '<div class="msg-box error-box box1">
        //             <div class="msg-content">
        //                 <div class="msg-icon"><i class="fas fa-times"></i></div>
        //                 <div class="msg-text text1">'.$a[$i].'</div>
        //             </div>
        //         </div>';
        //     }
        // }
        // echo $html;
    //} ?>
	<?php if($this->session->getFlashdata('message')){ ?>
		<div class="msg-box error-box box1">
			<div class="msg-content">
				<div class="msg-icon"><i class="fas fa-times"></i></div>
				<div class="msg-text text1"><?= $this->session->getFlashdata('message'); ?></div>
			</div>
		</div>
    </div>
	<?php } ?>
<script>
$(document).ready(function($) {
	select_designation();
	if ($(".text1 ul").text() != ''){
		$('.msg-container .box1').attr('style','display:block');
		setTimeout(function() {
			$('.msg-container .box1').attr('style','display:none');
		}, 6000);
	}
	$('#designation').change(function(){
		var id = $(this).val();
		var skills = $('#'+id+'_skills').text();
		$('#skills').val(skills);
		select_designation();
	});
	/* $('#upload_resume').change(function(){
		var resume = $(this).val();
		$('#upload-text span').text(resume);
	}); */
	$("#candidate-form").submit(function(e) {
        var name = $("#name").val();
        var email = $("#email").val();
        var phone_number = $("#phone_number").val();
        var designation = $("#designation").val();
        var experience = $("#experience").val();

        var current_salary = $("#current_salary").val();
        var expected_salary = $("#expected_salary").val();
        var upload_resume = $("#upload_resume").val();
		
        // var interview_date = $("#interview_date").val();
        //var interview_status = $("#interview_status").val();
        var gender = true;
        $('#gender').each(function() {
            gender = gender && $(this).is(':checked');
        });
        //console.log(gender);
        var address = $("#address").val();
        // var feedback = $("#feedback").val();
        var skills = $("#skills").val();
		// || !interview_date || !feedback
        if (!name || !email || !designation || !experience || !current_salary || !expected_salary  || !phone_number || !address || !skills || !upload_resume) {
            e.preventDefault();
            if (!name) {
                $("#name").addClass('error');
            } else {
                $("#name").removeClass('error');
            }
            
            if (!email) {
                $("#email").addClass('error');
            } else {
                $("#email").removeClass('error');
            }
            
             if(!phone_number){
              $("#phone_number").addClass('error');
            }
            else{
              $("#phone_number").removeClass('error');
            } 
             if(!designation){
                $("#designation").addClass('error');
              }
              else{
                $("#designation").removeClass('error');
              } 
            if (!experience) {
                $("#experience").addClass('error');
            } else {
                $("#experience").removeClass('error');
            }
           
            if(!current_salary){
              $("#current_salary").addClass('error');
            }
            else{
              $("#current_salary").removeClass('error');
            } 

            if (!expected_salary) {
                $("#expected_salary").addClass('error');
            } else {
                $("#expected_salary").removeClass('error');
			}
             if(!upload_resume){
				 
              $("#upload_resume").parent().addClass('error');
            }
            else{
              $("#upload_resume").parent().removeClass('error');
            } 
           /*  if(!interview_date){
              $("#interview_date").addClass('error');
            }
            else{
              $("#interview_date").removeClass('error');
            } */
            
            /* if(!feedback){
              $("#feedback").addClass('error');
            }
            else{
              $("#feedback").removeClass('error');
            } */ 
            if(!skills){
              $("#skills").parent().addClass('error');
            }
            else{
              $("#skills").parent().removeClass('error');
            } 
             if(!address){
              $("#address").addClass('error');
            }
            else{
              $("#address").removeClass('error');
            } 
           
            				console.log("erer");

           
            return false;
        } else {
			
            $("#name").removeClass('error');
            $("#email").removeClass('error');
            $("#phone_number").removeClass('error');
            $("#designation").removeClass('error');
            $("#experience").removeClass('error');
            $("#current_salary").removeClass('error');
           
            $("#expected_salary").removeClass('error');
            $("#upload_resume").removeClass('error');
            // $("#interview_date").removeClass('error');
            // $("#interview_status").removeClass('error');
			// $("#feedback").removeClass('error');
			$("#skills").removeClass('error');
            $("#address").removeClass('error');
				console.log("ssdsdsd");
          
           
             return true;

        }
    }); 


     });
</script>