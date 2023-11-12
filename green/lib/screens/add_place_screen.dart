import 'dart:io';
import 'package:flutter/material.dart';
import 'package:image_picker/image_picker.dart';
import 'package:http/http.dart' as http;
import 'package:green/widgets/location_input.dart';


class LocationData {
  final double latitude;
  final double longitude;

  LocationData({required this.latitude, required this.longitude});
}

class AddPlaceScreen extends StatelessWidget {
  const AddPlaceScreen({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: 'Green Incident Reporter',
      theme: ThemeData(
        primaryColor: const Color(0xFF388E3C),
        colorScheme: ColorScheme.fromSwatch(
          primarySwatch: Colors.green,
        ).copyWith(
          secondary: const Color(0xFF4CAF50),
        ),
        fontFamily: 'Roboto',
      ),
      home: const IncidentReportForm(),
    );
  }
}

class IncidentReportForm extends StatefulWidget {
  const IncidentReportForm({Key? key}) : super(key: key);

  @override
  _IncidentReportFormState createState() => _IncidentReportFormState();
}

class _IncidentReportFormState extends State<IncidentReportForm> {
  TextEditingController descriptionController = TextEditingController();
  String selectedValue = 'no incident selected';
  List<String> items = [
    'no incident selected',
    'Bushfiring',
    'Logging',
    'Improper Waste Disposal',
    'Other Incident',
  ];

  String customIncidentDescription = '';
  bool showCustomDescription = false;

  late ImagePicker _imagePicker;
  XFile? _pickedImage;

  LocationData? _selectedLocation;

  String selectedLocationValue = 'Select Location';
  List<String> locationOptions = [
    'Select Location',
    'ARISA', 'SACEM-ARDHI UNIVERSITY',
    'ARDHI GETI DOGO CAFETERIA', 'Alimaua A', 'Mlalakua', 'Msisiri A',
    'Msisiri B', 'Ukwamami', 'Mwinjuma', 'Mkunguni A', 'Kambwangwa', 'Makongo',
    'Makongo 2', 'Mzimuni', 'Jogoo', 'Makongo 3', 'Wazo',
    'Other Location',
  ];

  TextEditingController customLocationController = TextEditingController();

  Future<void> _submitReport() async {
    ScaffoldMessenger.of(context).showSnackBar(
      SnackBar(
        content: Text('Report submitted successfully!'),
        duration: Duration(seconds: 3), // Adjust the duration as needed
      ),
    );


    try {
      // Check if the user has selected a valid incident type
      if (selectedValue == 'no incident selected') {
        _showErrorMessage('Please select an incident type.');
        return;
      }

      // Check if a photo has been selected
      if (_pickedImage == null) {
        _showErrorMessage('Please capture a photo.');
        return;
      }

      // Check if a valid location has been selected or if a custom location is provided
      if (selectedLocationValue == 'Select Location' && customLocationController.text.isEmpty) {
        _showErrorMessage('Please select a valid location or enter a custom location.');
        return;
      }

      // Prepare the data to be sent to the server
      final Map<String, dynamic> requestData = {
        'incident_type': showCustomDescription ? customIncidentDescription : selectedValue,
        'incident_description': showCustomDescription ? customIncidentDescription : selectedValue,
        'location': selectedLocationValue == 'Other Location' ? customLocationController.text : selectedLocationValue,
        // Add more data fields as needed
      };

      final http.MultipartRequest request = http.MultipartRequest(
        'POST',
        Uri.parse('http://10.0.2.2/submit_report/submit.php'),
      );

      // Add image file to the request
      final http.MultipartFile imageFile = await http.MultipartFile.fromPath(
        'image',
        _pickedImage!.path,
      );

      request.files.add(imageFile);

      // Add other fields to the request
      requestData.forEach((key, value) {
        request.fields[key] = value.toString();
      });

      final http.StreamedResponse response = await request.send();

      if (response.statusCode == 200) {
        // Successfully submitted
        ScaffoldMessenger.of(context).showSnackBar(
          SnackBar(
            content: Text('Report submitted successfully!'),
            duration: Duration(seconds: 3), // Adjust the duration as needed
          ),
        );

        // Clear the form data
        setState(() {
          selectedValue = 'no incident selected';
          descriptionController.clear();
          customIncidentDescription = '';
          _pickedImage = null;
          selectedLocationValue = 'Select Location';
          customLocationController.clear();
          _selectedLocation = null;
        });

        // You can add further logic or UI updates here
      } else {
        _showErrorMessage('Error: ${response.reasonPhrase}');
      }
    } catch (error) {
      _showErrorMessage('Error: $error');
    }
  }




  @override
  void initState() {
    super.initState();
    _imagePicker = ImagePicker();
  }

  Future<void> _pickImage() async {
    showDialog(
      context: context,
      builder: (BuildContext context) {
        return AlertDialog(
          title: const Text('Pick Image Source'),
          content: SingleChildScrollView(
            child: ListBody(
              children: [
                TextButton(
                  child: const Text('Camera'),
                  onPressed: () {
                    _pickImageFromSource(ImageSource.camera);
                    Navigator.of(context).pop();
                  },
                ),
                const SizedBox(height: 10),
                TextButton(
                  child: const Text('Gallery'),
                  onPressed: () {
                    _pickImageFromSource(ImageSource.gallery);
                    Navigator.of(context).pop();
                  },
                ),
              ],
            ),
          ),
        );
      },
    );
  }

  Future<void> _pickImageFromSource(ImageSource source) async {
    final XFile? pickedImage = await _imagePicker.pickImage(source: source);

    if (pickedImage != null) {
      setState(() {
        _pickedImage = pickedImage;
      });
    }
  }

  void _showErrorMessage(String message) {
    showDialog(
      context: context,
      builder: (BuildContext context) {
        return AlertDialog(
          title: Text('Error'),
          content: Text(message),
          actions: <Widget>[
            TextButton(
              child: Text('OK'),
              onPressed: () {
                Navigator.of(context).pop(); // Close the dialog
              },
            ),
          ],
        );
      },
    );
  }


  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text(
          'Green Incident Report Form',
          style: TextStyle(color: Colors.white),
        ),
        backgroundColor: Theme.of(context).primaryColor,
      ),
      body: SingleChildScrollView(
        child: Padding(
          padding: const EdgeInsets.all(16.0),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Text(
                'Select the type of incident or harmful activity you want to report:',
                style: TextStyle(
                  fontSize: 18,
                  fontWeight: FontWeight.bold,
                  color: Theme.of(context).primaryColor,
                ),
              ),
              const SizedBox(height: 10),
              DropdownButtonHideUnderline(
                child: DropdownButton<String>(
                  isExpanded: true,
                  hint: Text(
                    'Select Incident',
                    style: TextStyle(
                      fontSize: 16,
                      color: Theme.of(context).hintColor,
                    ),
                  ),
                  items: items
                      .map((String item) => DropdownMenuItem<String>(
                    value: item,
                    child: Text(
                      item,
                      style: TextStyle(
                        fontSize: 16,
                        color: selectedValue == item
                            ? Colors.black
                            : Colors.grey,
                      ),
                    ),
                  ))
                      .toList(),
                  value: selectedValue,
                  onChanged: (String? value) {
                    setState(() {
                      selectedValue = value!;
                      showCustomDescription = value == 'Other Incident';
                    });
                  },
                  style: const TextStyle(fontSize: 16),
                ),
              ),
              if (showCustomDescription) ...[
                const SizedBox(height: 20),
                const Text(
                  'Or describe the incident:',
                  style: TextStyle(
                    fontSize: 16,
                    fontWeight: FontWeight.bold,
                  ),
                ),
                const SizedBox(height: 10),
                TextField(
                  controller: descriptionController,
                  decoration: const InputDecoration(
                    hintText: 'Enter your custom incident description',
                  ),
                  style: const TextStyle(color: Colors.black),
                  onChanged: (value) {
                    setState(() {
                      customIncidentDescription = value;
                    });
                  },
                ),
              ],
              ElevatedButton.icon(
                onPressed: _pickImage,
                icon: const Icon(Icons.camera_alt),
                label: const Text('Capture Photo'),
                style: ElevatedButton.styleFrom(
                  backgroundColor:
                  Theme.of(context).colorScheme.secondary,
                ),
              ),
              if (_pickedImage != null)
                Padding(
                  padding: const EdgeInsets.all(16.0),
                  child: SizedBox(
                    width: 350,
                    height: 200,
                    child: Image.file(File(_pickedImage!.path)),
                  ),
                ),
              const SizedBox(height: 40),
              LocationInput(
                onSelectLocation: (location) {
                  setState(() {
                    _selectedLocation = LocationData(
                      latitude: location.latitude,
                      longitude: location.longitude,
                    );
                  });
                },
              ),
              const SizedBox(height: 20),
              DropdownButton<String>(
                value: selectedLocationValue,
                onChanged: (newValue) {
                  setState(() {
                    selectedLocationValue = newValue!;
                  });
                },
                items: locationOptions.map((String location) {
                  return DropdownMenuItem<String>(
                    value: location,
                    child: Text(location),
                  );
                }).toList(),
              ),
              if (selectedLocationValue == 'Other Location') ...[
                const SizedBox(height: 20),
                const Text(
                  'Or enter the location:',
                  style: TextStyle(
                    fontSize: 16,
                    fontWeight: FontWeight.bold,
                  ),
                ),
                const SizedBox(height: 10),
                TextField(
                  controller: customLocationController,
                  decoration: const InputDecoration(
                    hintText: 'Enter your custom location',
                  ),
                  style: const TextStyle(color: Colors.black),
                ),
              ],
              const SizedBox(height: 20),
              Align(
                alignment: Alignment.center,
                child: ElevatedButton(
                  onPressed: _submitReport,
                  child: const Text('Submit'),
                  style: ElevatedButton.styleFrom(
                    backgroundColor: Theme.of(context).primaryColor,
                  ),
                ),
              ),
            ],
          ),
        ),
      ),
    );
  }
}

