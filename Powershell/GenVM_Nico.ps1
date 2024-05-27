cls
<#    
    
    ================================================================================
     Created with:  </VSCODE x64-1.75.1 2023 POWERSHELL CORE V. 7.4.0 />
     Created on:    07.05.2024 08:15
     Created by:    Feurstein Nico
     Organization:  Hilti Digital Foundation & IT Infrastructure P4 | DevOps-SysOps
     Filename:      GenVM_Nico
    ================================================================================

    
#>

# Setzt den Standard-Host für alle folgenden VM-Befehle
$defaultHost = "NESRV01"
$VMName = Get-Content -Path C:\xampp\htdocs\webside\VM_config.txt | Select -Index 0
[int64]$CPUCount =  Get-Content -Path C:\xampp\htdocs\webside\VM_config.txt | Select -Index 1
[int64]$RamSize = Get-Content -Path C:\xampp\htdocs\webside\VM_config.txt | Select -Index 2
$RamSize = $RamSize * 1073741824
[int64]$DiskSize = Get-Content -Path C:\xampp\htdocs\webside\VM_config.txt | Select -Index 3
$DiskSize = $DiskSize * 1073741824

# $VMName = "test1"
# $CPUCount = 6
# $RamSize = 10GB
# $DiskSize = 50GB


# Erstellen einer neuen VM
New-VM -Name $VMName -NoVHD -Path "C:\Hyper-V\" -Generation 2 -ComputerName $defaultHost

# Konfiguration der VM
Set-VM -Name $VMName -ProcessorCount $CPUCount -StaticMemory -MemoryStartupBytes $RamSize -CheckpointType Disabled -ComputerName $defaultHost

# Abfrage des Standard-Namens des Netzwerkadapters
$NicName = (Get-VMNetworkAdapter -VMName $VMName -ComputerName $defaultHost).Name 

# Umbenennen des Netzwerkadapters
Rename-VMNetworkAdapter -Name $NicName -VMName $VMName -NewName $VMName -ComputerName $defaultHost

# VSwitch auf extern stellen
Get-VM -Name $VMName -ComputerName $defaultHost | Get-VMNetworkAdapter | Connect-VMNetworkAdapter -SwitchName "Extern"

# Aktivieren der Nested Virtualization
Set-VMProcessor -VMName $VMName -ExposeVirtualizationExtensions $true -ComputerName $defaultHost


# Kopieren dynamischer VHDs
Invoke-Command -ComputerName $defaultHost -ArgumentList	$VMName -ScriptBlock { 
    param(
        $VMName
    )
    Copy-Item -Path "D:\Hyper-V\defaults\Win10EnDefault.vhdx" -Destination "D:\Hyper-V\VMs\$VMName.vhdx" -Verbose
    
}
   
#Get-VMHardDiskDrive -VMName "default" -ComputerName $defaultHost | Select-Object Path -ExpandProperty Path 
Resize-VHD -path "D:\Hyper-V\VMs\$VMName.vhdx" -SizeBytes $DiskSize -ComputerName $defaultHost


# Hinzufügen der VHDs zur VM
Add-VMHardDiskDrive -Path "D:\Hyper-V\VMs\$VMName.vhdx" -VMName $VMName -ComputerName $defaultHost


# Neuordnen der Boot-Reihenfolge
$disk = Get-VMHardDiskDrive -VMName $VMName -ComputerName "NESRV01"
Set-VMFirmware -VMName $VMName -FirstBootDevice $disk -ComputerName $defaultHost


Start-VM -Name $VMName -ComputerName $defaultHost


Start-Sleep -Seconds 120

#--------------------------------------------------------------------------------------------------------------------------------------------------#

# Set Autologon

<#

$Urk = 'Win10EnDefault\User'
$Prk = ConvertTo-SecureString 'default' -AsPlainText -Force
$usercred = [pscredential]::New($Urk, $Prk)


Invoke-Command -ComputerName "Win10EnDefault" -ScriptBlock {
        
                #Get-ItemProperty 'HKLM:\SOFTWARE\Microsoft\Windows NT\CurrentVersion\Winlogon' DefaultUsername, DefaultPassword
        
                      
                $RegPath = "HKLM:\SOFTWARE\Microsoft\Windows NT\CurrentVersion\Winlogon"
                $DefaultUsername = "User"
                $DefaultPassword = "default"
                $DefaultDomainName = "Workgroup"
                Set-ItemProperty $RegPath "AutoAdminLogon" -Value "1" -type String 
                Set-ItemProperty $RegPath "DefaultUsername" -Value "$DefaultUsername" -type String 
                Set-ItemProperty $RegPath "DefaultPassword" -Value "$DefaultPassword" -type String
                Set-ItemProperty $RegPath "DefaultDomainName" -Value "$DefaultDomainName" -type String 
        
                Start-Sleep -Seconds 3
                Get-ItemProperty 'HKLM:\SOFTWARE\Microsoft\Windows NT\CurrentVersion\Winlogon' DefaultUsername, DefaultPassword -Verbose

                Restart-Computer -Force

        
            } -Credential $usercred


Start-Sleep -Seconds 60

#>


#--------------------------------------------------------------------------------------------------------------------------------------------------#

# Windows aktivieren


$Urk = 'Win10EnDefault\User'
$Prk = ConvertTo-SecureString 'default' -AsPlainText -Force
$usercred = [pscredential]::New($Urk, $Prk)
$Session = New-PSSession -ComputerName "Win10EnDefault" -Credential $usercred


Copy-Item -Path 'R:\activision\activate_windows\HWID_Activation.cmd' -Destination 'C:\Users\User\Documents\HWID_Activation.cmd' -ToSession $Session -force -Verbose
Remove-PSSession $session -Verbose



Invoke-Command -ComputerName "Win10EnDefault" -ScriptBlock { 
    

    Start-Process -FilePath "C:\Users\User\Documents\HWID_Activation.cmd"

    Start-Sleep -Seconds 30
    
    Remove-Item -Path "C:\Users\User\Documents\HWID_Activation.cmd"
    
}-Credential $usercred


Start-Sleep -Seconds 5

#--------------------------------------------------------------------------------------------------------------------------------------------------#


# Freie IP Adressen werden aus einer Liste nach freien abgesucht
$Urk = 'Win10EnDefault\User'
$Prk = ConvertTo-SecureString 'default' -AsPlainText -Force
$usercred = [pscredential]::New($Urk, $Prk)
$ipAddresses = Get-Content "R:\Powershell\Server_PS_creation\IPs.txt"


function Get-FreeIPAddress {
    foreach ($ip in $ipAddresses) {
        $result = Test-Connection $ip -Count 2 -Quiet
        if($result -eq $false){
            $isfree = $true
            $value = @("$isfree", "$ip")

            return $value

        } 
    }
}

$isfree = $false
$value = Get-FreeIPAddress
$isfree = $value[0]
$freeip = $value[1]


# Die freie IP wird eingetragen 
if ($isfree -eq $true) {
    Write-Host "Freie IP gefunden: $freeip"

    Start-Sleep -Seconds 60

    Invoke-Command -ComputerName "Win10EnDefault" -ArgumentList $freeIP -ScriptBlock {
        param(
            $freeip
        )
        $ifIndex = Get-NetAdapter | Select-Object -ExpandProperty ifIndex
        Set-DnsClientServerAddress -InterfaceIndex $ifIndex -ServerAddresses ("10.100.187.10")
        #Set-NetIPAddress -InterfaceIndex $ifIndex -IPAddress $freeip -PrefixLength 24
        New-NetIPAddress -InterfaceIndex $ifIndex -IPAddress $freeip -PrefixLength 24 -DefaultGateway "10.100.187.1"
    } -Credential $usercred
    Write-Host "IP-Adresse wurde gesetzt." -ForegroundColor Green
} else {
    Write-Host "Keine freie IP-Adresse verfügbar. Benutze DHCP!!!!" -ForegroundColor Red
}

Start-Sleep -Seconds 40


# Setze Computername
Invoke-Command -ComputerName "Win10EnDefault" -ArgumentList $VMName -ScriptBlock {
    param(
        $VMName
    )
    Rename-Computer -NewName $VMName

    Restart-Computer -Force
} -Credential $usercred




Start-Sleep -Seconds 120

#--------------------------------------------------------------------------------------------------------------------------------------------------#


# Partition anpassen
$Urk = '$VMName\User'
$Prk = ConvertTo-SecureString 'default' -AsPlainText -Force
$usercred = [pscredential]::New($Urk, $Prk)


Invoke-Command -ComputerName "$VMName" -ScriptBlock {
   
    
    Remove-Partition -DiskNumber 0 -PartitionNumber 4 -Confirm:$false -Verbose
   
    Restart-Computer -Force

}-Credential $usercred


 Start-Sleep -Seconds 120


Invoke-Command -ComputerName "$VMName" -ScriptBlock {

    $maxSize = (Get-PartitionSupportedSize -DriveLetter C).sizeMax
    
        
    Resize-Partition -DiskNumber 0 -PartitionNumber 3 -Size "$maxSize" -Verbose

    

}-Credential $usercred

Start-Sleep -Seconds 20

#--------------------------------------------------------------------------------------------------------------------------------------------------#



Remove-Item -Path C:\xampp\htdocs\webside\VM_config.txt






