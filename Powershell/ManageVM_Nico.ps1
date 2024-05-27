cls
# Setzt den Standard-Host für alle folgenden VM-Befehle
$defaultHost = "NESRV01"
$VMName = Get-Content -Path C:\xampp\htdocs\webside\change_vm.txt | Select -Index 0
$aktion = Get-Content -Path C:\xampp\htdocs\webside\change_vm.txt | Select -Index 1 
[int64]$CPUCount =  Get-Content -Path C:\xampp\htdocs\webside\change_vm.txt | Select -Index 2
[int64]$RamSize = Get-Content -Path C:\xampp\htdocs\webside\change_vm.txt | Select -Index 3
$RamSize = $RamSize * 1073741824
[int64]$DiskSize = Get-Content -Path C:\xampp\htdocs\webside\change_vm.txt | Select -Index 4
$DiskSize = $DiskSize * 1073741824






& $aktion-vm -Name $VMName -ComputerName $defaultHost 


Stop-VM -Name $VMName -ComputerName $defaultHost

Set-VM -Name $VMName -ProcessorCount $CPUCount -ComputerName $defaultHost 
Set-VM -Name $VMName -StaticMemory -MemoryStartupBytes $RamSize -ComputerName $defaultHost
Resize-VHD -path "D:\Hyper-V\VMs\$VMName.vhdx" -SizeBytes $DiskSize -ComputerName $defaultHost

Start-VM -Name $VMNAME -ComputerName $defaultHost

Start-Sleep -Seconds 120


Invoke-Command -ComputerName "$VMName" -ScriptBlock {

    $maxSize = (Get-PartitionSupportedSize -DriveLetter C).sizeMax
    
        
    Resize-Partition -DiskNumber 0 -PartitionNumber 3 -Size "$maxSize" -Verbose

    

}-Credential $usercred


