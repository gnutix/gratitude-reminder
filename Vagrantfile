# Vagrantfile API/syntax version. Don't touch unless you know what you're doing!
VAGRANTFILE_API_VERSION = "2"

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|

    # do special stuff in case the hostmaster plugin is installed
    if Vagrant.has_plugin?("vagrant-hostmanager")
        config.hostmanager.enabled = true
        config.hostmanager.manage_host = true
    end

    config.vm.box = "ubuntu/trusty64"

    config.vm.synced_folder ".", "/vagrant", :nfs => true
    config.vm.hostname = "gratitude.lo"
    config.vm.network :private_network, ip: '10.10.10.40'

    config.vm.provider "virtualbox" do |virtualbox|
        virtualbox.customize ["modifyvm", :id, "--name", "gratitude"]
        virtualbox.customize ["modifyvm", :id, "--memory", "1024"]
    end

    if Vagrant.has_plugin?("vagrant-hostmanager")
        config.vm.provision :hostmanager
    end

    config.vm.provision :shell, :path => "scripts/provisioning/vagrant.sh", :privileged => false, :args => "/vagrant"
end
