U := ingprog

ansible-development-setup:
	mkdir -p tmp
	echo '' >> tmp/ansible-vault-password
	ansible-playbook ansible/development.yml -i ansible/development -vv

install-yii:
	cd app && git clone https://github.com/yiisoft/yii.git

run-dev:
	docker-compose -f docker-compose_dev.yml up -d

migrate-dev:
	docker-compose -f docker-compose_dev.yml run php make migrate

run:
	docker-compose up -d

kill:
	docker-compose kill

ansible-production-setup:
	mkdir -p tmp
	echo '' >> tmp/ansible-vault-password
	ansible-playbook ansible/production.yml -i ansible/production -vv

ansible-vaults-encrypt:
	ansible-vault encrypt ansible/production/group_vars/all/vault.yml

ansible-vaults-decrypt:
	ansible-vault decrypt ansible/production/group_vars/all/vault.yml

update-autoload:
	docker-compose run php make update-autoload

build-dev:
	docker-compose -f docker-compose_dev.yml build

build-prod:
	docker-compose build

run-deploy:
	ansible-playbook ansible/deploy.yml -i ansible/production -u $U -vv

push:
	git push origin master
