@update_ceska_posta_balikomaty_branches
Feature: Download the list of current Česká Pošta Balíkomaty branches
	In order to update local list of Česká Pošta Balíkomaty branches with live list of branches
	As an Administrator
	Download current Česká Pošta Balíkomaty branches and update it

	Background:
		Given the store operates on a single channel in "United States"
		And the store allows shipping with "DHL"
		And the store allows shipping with "Česká Pošta Balíkomaty"
		And this shipping method has Česká Pošta Balíkomaty enabled
		And the store has Česká Pošta Balíkomat "Test1"
		And the store has Česká Pošta Balíkomat "Test2"
		And I am logged in as an administrator

	@ui
	Scenario: Run the command and download and create Česká Pošta Balíkomaty branches
		Given I update Česká Pošta Balíkomaty branches
		Then the store should has Česká Pošta Balíkomat "Test3"

	@ui
	Scenario: Run the command and download and update Česká Pošta Balíkomaty branches
		Given I update Česká Pošta Balíkomaty branches
		Then the store should has Česká Pošta Balíkomat "Test1"

	@ui
	Scenario: Run the command and download and disable Česká Pošta Balíkomaty branches
		Given I update Česká Pošta Balíkomaty branches
		Then the store should has disabled Česká Pošta Balíkomat "Test2"

	@ui
	Scenario: Action download and update Česká Pošta Balíkomaty branches is disabled
		Given I want to modify a shipping method "DHL"
		Then action download and update Česká Pošta Balíkomaty branches is not available

	@ui
	Scenario: Run action download and update Česká Pošta Balíkomaty branches from shipping method edit form in the admin panel
		Given I want to modify a shipping method "Česká Pošta Balíkomaty"
		Then action download and update ceskaPostaBalikomaty branches is available
		And click to action download and update Česká Pošta Balíkomaty branches
		Then I should be notified that Česká Pošta Balíkomaty branches has been successfully updated
		And the store should has Česká Pošta Balíkomat "Test1"
