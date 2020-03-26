@enable_balikomat_in_shipping_method
Feature: Enable Česká Pošta Balíkomat  in shipping method
	In order to enable Česká Pošta Balíkomaty in shipping method settings in admin panel
	As an Administrator
	I want to enable Česká Pošta Balíkomat in shipping method

	Background:
		Given the store operates on a single channel in "United States"
		And the store allows shipping with "Česká Pošta Balíkomaty" identified by "ceska_posta_balikomaty"
		And I am logged in as an administrator

	@ui
	Scenario: Enable Česká Pošta Balíkomaty in shipping method
		Given I want to modify a shipping method "Česká Pošta Balíkomaty"
		When I enable PPL parcelshops
		And I save my changes
		Then I should be notified that it has been successfully edited
		And the PPL parcelshops shoul be enabled

	@ui
	Scenario: Disable Česká Pošta Balíkomaty in shipping method
		Given I want to modify a shipping method "Česká Pošta Balíkomaty"
		When I disable PPL parcelshops
		And I save my changes
		Then I should be notified that it has been successfully edited
		And the PPL parcelshops shoul be disabled
