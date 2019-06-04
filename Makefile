U := ingprog

ansible-development-setup:
	mkdir -p tmp
	echo 'pass' >> tmp/ansible-vault-password
	ansible-playbook ansible/development.yml -i ansible/development -vv

yii:
	cd app && git clone https://github.com/yiisoft/yii.git

install:
	docker-compose run php make install

migrate-dev:
	docker-compose -f docker-compose_dev.yml run php make migrate

seed:
	docker-compose run php make seed

compose-setup: yii install migrate-dev seed

dev:
	docker-compose -f docker-compose_dev.yml up -d


kill:
	docker-compose kill

ansible-vaults-encrypt:
	ansible-vault encrypt ansible/production/group_vars/all/vault.yml

ansible-vaults-decrypt:
	ansible-vault decrypt ansible/production/group_vars/all/vault.yml

build-dev:
	docker-compose -f docker-compose_dev.yml build
